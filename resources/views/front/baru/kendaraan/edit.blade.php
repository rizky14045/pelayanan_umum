@extends('front.baru.master')
@section('content')
<div class="gap"></div>
<div class="container">
    <div class="row row-wrap">
        <div class="col-md-12">
            <h4>Formulir Permohonan Kendaraan</h4>    
            <form action="{{ route('permohonankendaraan.update', [$permohonan->id]) }}" class="colorlib-form" method="POST">
                {!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tujuan">
                                Tujuan
                            </label>
                            <div class="form-field">
                                <input class="form-control" name="tujuan" id="input-tujuan" value="{{ $permohonan->tujuan }}" placeholder="Masukkan Tujuan" type="text"/>
                                <input type="hidden" name="latlng" id="input-latlng" value="{{ $permohonan->latlng }}">
                            </div>
                        </div>
                        <div id="googleMap" style="width:100%;height:300px;border-radius:6px;"></div>
                        <small style="display:block;margin-top:5px;color:#1F5C85;font-weight:600;"><i class="fa fa-map-marker"></i> Tips: Klik atau geser pin pada peta untuk menentukan lokasi tujuan.</small>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="pemohon">
                                        Pemohon
                                    </label>
                                    <div class="form-field">
                                        <input class="form-control" name="pemohon" value="{{ $permohonan->pemohon }}" readonly="" type="text" value="{{ $pemohon['nama'] }}"/>
                                        <input class="form-control" name="pemohon_id"type="hidden" value="{{ $pemohon['id'] }}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="keperluan">
                                        Keperluan
                                    </label>
                                    <div class="form-field">
                                        <input class="form-control" id="keperluan" name="keperluan" value="{{ $permohonan->keperluan }}" placeholder="Masukkan keperluan" type="text">
                                        </input>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="penanggung_jawab">
                                        Penanggung Jawab
                                    </label>
                                    <label for="penanggung_jawab">
                                        Nama Pemesan <span style="color:red;">*</span>
                                    </label>
                                    <div class="form-field">
                                        <input type="text" class="form-control" name="penanggung_jawab" value="{{ $permohonan->penanggung_jawab }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_perjalanan">
                                        Jenis Perjalanan <span style="color:red;">*</span>
                                    </label>
                                    <div class="form-field">
                                        <select class="form-control" name="jenis_perjalanan" id="jenis_perjalanan" required>
                                            <option value="" disabled {{ $permohonan->jenis_perjalanan ? '' : 'selected' }}>Pilih Jenis Perjalanan</option>
                                            <option value="Pergi Saja" {{ $permohonan->jenis_perjalanan == 'Pergi Saja' ? 'selected' : '' }}>Pergi Saja</option>
                                            <option value="Pulang Pergi" {{ $permohonan->jenis_perjalanan == 'Pulang Pergi' ? 'selected' : '' }}>Pulang Pergi</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_berangkat">
                                        Tanggal Berangkat
                                    </label>
                                    <div class="form-field">
                                        <input class="form-control input-date/" id="tanggal_berangkat" name="tanggal_berangkat" value="{{ $permohonan->tanggal_berangkat }}" placeholder="Tanggal Berangkat" type="date">
                                        </input>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_kembali">
                                        Tanggal Kembali
                                    </label>
                                    <div class="form-field">
                                        <input class="form-control input-date/" id="tanggal_kembali" name="tanggal_kembali" value="{{ $permohonan->tanggal_kembali }}" placeholder="Tanggal Berangkat" type="date">
                                        </input>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_berangkat">
                                        Jam Berangkat
                                    </label>
                                    <div class="form-field">
                                        <i class="icon icon-calendar2"></i>
                                        <input class="form-control time" id="jam_berangkat" name="jam_berangkat" value="{{ $permohonan->jam_berangkat }}" placeholder="Jam Berangkat" type="time">
                                        </input>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jam_kembali">
                                        Jam Kembali
                                    </label>
                                    <div class="form-field">
                                        <i class="icon icon-calendar2"></i>
                                        <input class="form-control time" id="jam_kembali" name="jam_kembali" value="{{ $permohonan->jam_kembali }}" placeholder="Jam Kembali" type="time">
                                        </input>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="keterangan">
                                        Keterangan
                                    </label>
                                    <div class="form-field">
                                        <input class="form-control" name="keterangan" value="{{ $permohonan->keterangan }}" placeholder="Masukkan Keterangan" type="text"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <input style="margin-top: 25px;" class="btn btn-primary btn-block" id="submit" name="submit" type="submit" value="Simpan">
                                </input>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
  delete L.Icon.Default.prototype._getIconUrl;
  L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
    iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
  });

  var originCoords = [-6.1114326, 106.7821099]; // [lat, lng]
  var map = L.map('googleMap').setView(originCoords, 13);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);

  var originMarker = L.marker(originCoords).addTo(map).bindPopup('<b>UP Muara Karang</b><br>Titik Keberangkatan');
  var destinationMarker = null;
  var routeLayer = null;

  var input2 = document.getElementById("input-tujuan");
  var inputLatlng = document.getElementById("input-latlng");
  var justSelectedPlace = false;

  // Create suggestion box
  var wrapper = document.createElement('div');
  wrapper.className = 'osm-autocomplete-wrapper';
  input2.parentNode.insertBefore(wrapper, input2);
  wrapper.appendChild(input2);

  var resultsList = document.createElement('ul');
  resultsList.className = 'osm-autocomplete-results';
  resultsList.style.display = 'none';
  wrapper.appendChild(resultsList);

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
    if (inputLatlng) {
      inputLatlng.value = destLat + ',' + destLng;
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

  // Klik langsung di peta untuk menentukan titik tujuan jika tidak ditemukan di pencarian
  map.on('click', function(e) {
    var lat = e.latlng.lat;
    var lng = e.latlng.lng;
    resultsList.style.display = 'none';
    reverseGeocode(lat, lng, function(address) {
      justSelectedPlace = true;
      input2.value = address;
      drawRoute(lat, lng, address);
    });
  });

  // Load existing destination on ready
  $(document).ready(function() {
    var latlngVal = inputLatlng ? inputLatlng.value : '';
    if (latlngVal && latlngVal.indexOf(',') !== -1) {
      var parts = latlngVal.split(',');
      var lat = parseFloat(parts[0]);
      var lng = parseFloat(parts[1]);
      if (!isNaN(lat) && !isNaN(lng)) {
        drawRoute(lat, lng, input2.value);
        return;
      }
    }

    // If no latlng but text exists, geocode via Nominatim
    var initialText = input2.value ? input2.value.trim() : '';
    if (initialText) {
      fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(initialText) + '&countrycodes=id&limit=1')
        .then(function(res) { return res.json(); })
        .then(function(items) {
          if (items && items.length > 0) {
            var lat = parseFloat(items[0].lat);
            var lon = parseFloat(items[0].lon);
            if (inputLatlng) inputLatlng.value = lat + ',' + lon;
            drawRoute(lat, lon, initialText);
          }
        })
        .catch(function(err) {
          console.error('Geocode initial error:', err);
        });
    }
  });

  var searchTimer = null;
  input2.addEventListener('input', function() {
    if (justSelectedPlace) {
      justSelectedPlace = false;
      return;
    }
    if (inputLatlng) inputLatlng.value = "";

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
</script>
<script>
    function changeFunc(value) {
        $.ajax({
            url: "{{url('api/permohonankonsumsi/')}}?id=" + value,

            success: function (result) {
                console.log(result);
                $("[name='kegiatan']").val(result.nama_acara);
                $("[name='tanggal']").val(result.tanggal);
                $("[name='jam']").val(result.waktu_awal);
                $("[name='jumlah_peserta']").val(result.jumlah_peserta);
                $("[name='ruang']").val(result.nama_ruang);
                $("[name='jenis_konsumsi']").val(result.makanan);
            }
        });
    }
</script>
@endsection