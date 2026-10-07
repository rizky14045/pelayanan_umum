@extends('admin::layout.master')

@section('content')
@include('admin::partials.alert-messages')
<div class="block-header">
    <h2>Edit Surat Perintah Jalan</h2>
</div>
<div class="card">
  <div class="body">
    {!! $form->render() !!}
  </div>
</div>
@stop

@script
<script>
  delete L.Icon.Default.prototype._getIconUrl;
  L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
    iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
  });

  var originCoords = [-6.1114326, 106.7821099]; // [lat, lng]
  var mapElement = document.getElementById('map-input-latlng');
  var map = mapElement ? L.map('map-input-latlng').setView(originCoords, 13) : null;
  if (map) {
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
  }

  var originMarker = map ? L.marker(originCoords).addTo(map).bindPopup('<b>UP Muara Karang</b><br>Titik Keberangkatan') : null;
  var destinationMarker = null;
  var routeLayer = null;

  var input2 = document.getElementById("input-tujuan");
  var inputLatlng = document.getElementById("input-latlng");
  var INVALID_TUJUAN_MESSAGE = "Pilih salah satu lokasi tujuan dari daftar saran yang muncul.";
  var justSelectedPlace = false;

  function reverseGeocode(lat, lng, callback) {
    fetch('https://nominatim.openstreetmap.org/reverse?format=json&lat=' + lat + '&lon=' + lng + '&addressdetails=1')
      .then(function(res) { return res.json(); })
      .then(function(data) {
        if (data && data.display_name) {
          callback(data.display_name);
        } else {
          callback('Lokasi Titik Peta (' + lat.toFixed(5) + ', ' + lng.toFixed(5) + ')');
        }
      })
      .catch(function() {
        callback('Lokasi Titik Peta (' + lat.toFixed(5) + ', ' + lng.toFixed(5) + ')');
      });
  }

  function drawRoute(destLat, destLng, destName) {
    if (!map) return;
    if (inputLatlng) {
      inputLatlng.value = destLat + ',' + destLng;
    }
    if (input2) {
      input2.setCustomValidity("");
    }
    if (destinationMarker) {
      destinationMarker.setLatLng([destLat, destLng]);
    } else {
      destinationMarker = L.marker([destLat, destLng], { draggable: true }).addTo(map);
      destinationMarker.on('dragend', function(ev) {
        var pos = ev.target.getLatLng();
        reverseGeocode(pos.lat, pos.lng, function(address) {
          justSelectedPlace = true;
          input2.value = address;
          drawRoute(pos.lat, pos.lng, address);
        });
      });
    }
    destinationMarker.bindPopup('<b>Tujuan:</b><br>' + (destName || '')).openPopup();

    var osrmUrl = 'https://router.project-osrm.org/route/v1/driving/106.7821099,-6.1114326;' + destLng + ',' + destLat + '?overview=full&geometries=geojson';
    fetch(osrmUrl)
      .then(function(res) { return res.json(); })
      .then(function(data) {
        if (data.code === 'Ok' && data.routes && data.routes.length > 0) {
          var distanceKm = data.routes[0].distance / 1000;
          var totalDistance = distanceKm * 2;
          $("#input-jarak").val(parseFloat(totalDistance.toFixed(2)));
          if ($("#input-rute").length) {
            $("#input-rute").val(JSON.stringify(data.routes[0].geometry));
          }

          if (routeLayer) {
            map.removeLayer(routeLayer);
          }
          routeLayer = L.geoJSON(data.routes[0].geometry, {
            style: { color: '#1F5C85', weight: 5, opacity: 0.8 }
          }).addTo(map);

          map.fitBounds(routeLayer.getBounds(), { padding: [40, 40] });
        }
      })
      .catch(function(err) {
        console.error('OSRM Route error:', err);
      });
  }

  // Load existing destination on ready
  $(document).ready(function() {
    var latlngVal = inputLatlng ? inputLatlng.value : '';
    if (latlngVal && latlngVal.indexOf(',') !== -1) {
      var parts = latlngVal.split(',');
      var lat = parseFloat(parts[0]);
      var lng = parseFloat(parts[1]);
      if (!isNaN(lat) && !isNaN(lng)) {
        drawRoute(lat, lng, input2 ? input2.value : '');
        return;
      }
    }

    var initialText = input2 ? input2.value.trim() : '';
    if (initialText) {
      fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(initialText) + '&countrycodes=id&limit=1')
        .then(function(res) { return res.json(); })
        .then(function(items) {
          if (items && items.length > 0) {
            drawRoute(parseFloat(items[0].lat), parseFloat(items[0].lon), initialText);
          }
        })
        .catch(function(err) {
          console.error('Geocode initial error:', err);
        });
    }
  });

  // Klik langsung di peta untuk menentukan titik tujuan jika tidak ditemukan di pencarian
  if (map) {
    map.on('click', function(e) {
      var lat = e.latlng.lat;
      var lng = e.latlng.lng;
      if (resultsList) resultsList.style.display = 'none';
      reverseGeocode(lat, lng, function(address) {
        justSelectedPlace = true;
        if (input2) input2.value = address;
        drawRoute(lat, lng, address);
      });
    });
  }

  if (input2) {
    // Create suggestion box
    var wrapper = document.createElement('div');
    wrapper.className = 'osm-autocomplete-wrapper';
    input2.parentNode.insertBefore(wrapper, input2);
    wrapper.appendChild(input2);

    var resultsList = document.createElement('ul');
    resultsList.className = 'osm-autocomplete-results';
    resultsList.style.display = 'none';
    wrapper.appendChild(resultsList);

    var searchTimer = null;
    input2.addEventListener('input', function() {
      if (justSelectedPlace) {
        justSelectedPlace = false;
        return;
      }
      if (inputLatlng) inputLatlng.value = "";
      input2.setCustomValidity(input2.value.trim().length > 0 ? INVALID_TUJUAN_MESSAGE : "");

      clearTimeout(searchTimer);
      var query = input2.value.trim();
      if (query.length < 3) {
        resultsList.style.display = 'none';
        resultsList.innerHTML = '';
        return;
      }

      searchTimer = setTimeout(function() {
        fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query) + '&countrycodes=id&limit=5&addressdetails=1')
          .then(function(res) { return res.json(); })
          .then(function(items) {
            resultsList.innerHTML = '';
            if (!items || items.length === 0) {
              var emptyLi = document.createElement('li');
              emptyLi.className = 'osm-autocomplete-item';
              emptyLi.style.cursor = 'default';
              emptyLi.textContent = 'Lokasi tidak ditemukan';
              resultsList.appendChild(emptyLi);
              resultsList.style.display = 'block';
              return;
            }
            items.forEach(function(item) {
              var li = document.createElement('li');
              li.className = 'osm-autocomplete-item';
              li.innerHTML = '<span class="osm-icon">📍</span> <span>' + item.display_name + '</span>';
              li.addEventListener('click', function() {
                justSelectedPlace = true;
                input2.value = item.display_name;
                if (inputLatlng) inputLatlng.value = item.lat + ',' + item.lon;
                input2.setCustomValidity("");
                resultsList.style.display = 'none';
                resultsList.innerHTML = '';

                drawRoute(parseFloat(item.lat), parseFloat(item.lon), item.display_name);
              });
              resultsList.appendChild(li);
            });
            resultsList.style.display = 'block';
          })
          .catch(function(err) {
            console.error('Nominatim search error:', err);
          });
      }, 350);
    });

    document.addEventListener('click', function(e) {
      if (!wrapper.contains(e.target)) {
        resultsList.style.display = 'none';
      }
    });

    if (inputLatlng && inputLatlng.value) {
      input2.setCustomValidity("");
    } else if (input2.value.trim().length > 0) {
      input2.setCustomValidity(INVALID_TUJUAN_MESSAGE);
    }

    $(input2.closest('form')).on('submit', function (e) {
      if (inputLatlng && !inputLatlng.value) {
        e.preventDefault();
        input2.setCustomValidity(INVALID_TUJUAN_MESSAGE);
        input2.reportValidity();
        swal('Tujuan Belum Valid', 'Silakan ketik lalu pilih salah satu lokasi tujuan dari daftar saran yang muncul di peta.', 'warning');
      }
    });
  }

  setInterval(function(){ 
    $.ajax({url: "{{url('api/biayapermeter')}}", success: function(result) {
      var jarak = $("[name='jarak']").val();
      if (jarak && result.value) {
        var total = parseFloat(jarak) * parseInt(result.value);
        $("[name='total_biaya']").val(total);
      }
    }});
  }, 5000);
</script>
@endscript