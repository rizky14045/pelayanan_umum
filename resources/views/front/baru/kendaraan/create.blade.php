@extends('front.baru.master')
@section('content')
<div class="gap"></div>
<div class="container">
    <div class="row row-wrap">
        <div class="col-md-12">
            <h4>Formulir Permohonan Kendaraan</h4>    
            <form action="{{ route('permohonankendaraan.submit') }}" class="colorlib-form" method="POST">
                {!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tujuan">
                                Tujuan <span style="color:red;">*</span>
                            </label>
                            <div class="form-field">
                                <textarea name="tujuan" id="input-tujuan" cols="30" rows="4" class="form-control" required></textarea>
                                <input type="hidden" name="latlng" id="input-latlng">
                                <small class="text-muted">Ketik lalu pilih dari daftar saran, <b>atau klik langsung pada peta</b> untuk menentukan titik.</small>
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
                                        <input class="form-control" name="pemohon" readonly="" type="text" value="{{ $pemohon['nama'] }}"/>
                                        <input class="form-control" name="pemohon_id"type="hidden" value="{{ $pemohon['id'] }}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="keperluan">
                                        Keperluan <span style="color:red;">*</span>
                                    </label>
                                    <div class="form-field">
                                        <input class="form-control" id="keperluan" name="keperluan" placeholder="Masukkan keperluan" type="text" required>
                                        </input>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="penanggung_jawab">
                                        Nama Pemesan <span style="color:red;">*</span>
                                    </label>
                                    <div class="form-field">
                                        <input type="text" class="form-control" name="penanggung_jawab" required>
                                        {{-- <select class="form-control" name="penanggung_jawab">
                                            <option>
                                                Please chooses
                                            </option>
                                            @foreach($array_pj_kendaraan as $manajer)
                                            <option style="color: black" value='{{ $manajer["id"] }}'>
                                                {{ $manajer["nama"] }}
                                            </option>
                                            @endforeach
                                        </select> --}}
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
                                            <option value="" disabled selected>Pilih Jenis Perjalanan</option>
                                            <option value="Pergi Saja">Pergi Saja</option>
                                            <option value="Pulang Pergi">Pulang Pergi</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tanggal_berangkat">
                                        Tanggal<span style="color:red;">*</span>
                                    </label>
                                    <div class="form-field">
                                        <input class="form-control input-date" id="tanggal_berangkat" name="range_date" required>
                                        </input>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_kembali">
                                        Tanggal Kembali <span style="color:red;">*</span>
                                    </label>
                                    <div class="form-field">
                                        <input class="form-control input-date/" id="tanggal_kembali" name="tanggal_kembali" placeholder="Tanggal Berangkat" type="date" required>
                                        </input>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_berangkat">
                                        Jam Berangkat <span style="color:red;">*</span>
                                    </label>
                                    <div class="form-field">
                                        <i class="icon icon-calendar2"></i>
                                        <input class="form-control time-awal" id="jam_berangkat" name="jam_berangkat" placeholder="Jam Berangkat" type="time" required>
                                        </input>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jam_kembali">
                                        Jam Kembali <span style="color:red;">*</span>
                                    </label>
                                    <div class="form-field">
                                        <i class="icon icon-calendar2"></i>
                                        <input class="form-control time-akhir" id="jam_kembali" name="jam_kembali" placeholder="Jam Kembali" type="time" required>
                                        </input>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tanggal_berangkat">
                                        Informasi Driver Yang Tersedia Saat Ini :
                                    </label>
                                    <div class="form-field">
                                        <select name="" id="driver_kendaraan" class="form-control driver_kendaraan" >
                                            @foreach ($driver as $item)
                                                <option value="">{{$item->nama_driver}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="keterangan">
                                        Keterangan
                                    </label>
                                    <div class="form-field">
                                        <textarea name="keterangan" class="form-control" cols="30" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <input style="margin-top: 25px;" class="btn btn-primary btn-block" id="submit" name="submit" type="submit" value="Submit">
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
  var INVALID_TUJUAN_MESSAGE = "Pilih salah satu lokasi tujuan dari daftar saran yang muncul.";
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

  var searchTimer = null;
  input2.addEventListener('input', function() {
    if (justSelectedPlace) {
      justSelectedPlace = false;
      return;
    }
    inputLatlng.value = "";
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
              inputLatlng.value = item.lat + ',' + item.lon;
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

  // Safety net in case the browser lets the form through anyway
  document.querySelector('form.colorlib-form').addEventListener('submit', function (e) {
    if (!inputLatlng.value) {
      e.preventDefault();
      input2.setCustomValidity(INVALID_TUJUAN_MESSAGE);
      input2.reportValidity();
      swal('Tujuan Belum Valid', 'Silakan ketik lalu pilih salah satu lokasi tujuan dari daftar saran yang muncul di peta.', 'warning');
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
{{-- <script>
     $('.input-date').on('change', function(){
        $("#driver_kendaraan").empty();
        var tanggal = $(this).val();
        var awal = $('.time-awal').val();
        var akhir = $('.time-akhir').val();

            $.ajax({
                    type: "GET",
                    url: "{{ url('/getdriver') . '/' }}" + tanggal +'/'+awal+'/' + akhir,
                    success: function(res) {
                        res.drivers.forEach(element => {
                            $('#driver_kendaraan').append("<option value="+element.id+">"+element.nama_driver+"</option>")
                        });
                    }
                });
            })
     $('.time-awal').on('change', function(){
        $("#driver_kendaraan").empty();
        var tanggal = $('.input-date').val();
        var awal = $(this).val();
        var akhir = $('.time-akhir').val();

            $.ajax({
                    type: "GET",
                    url: "{{ url('/getdriver') . '/' }}" + tanggal +'/'+awal+'/' + akhir,
                    success: function(res) {
                        res.drivers.forEach(element => {
                            $('#driver_kendaraan').append("<option value="+element.id+">"+element.nama_driver+"</option>")
                        });
                    }
                });
            })
     $('.time-akhir').on('change', function(){
        $("#driver_kendaraan").empty();
        var tanggal = $('.input-date').val();
        var awal = $('.time-awal').val();
        var akhir = $(this).val();

            $.ajax({
                    type: "GET",
                    url: "{{ url('/getdriver') . '/' }}" + tanggal +'/'+awal+'/' + akhir,
                    success: function(res) {
                        res.drivers.forEach(element => {
                            $('#driver_kendaraan').append("<option value="+element.id+">"+element.nama_driver+"</option>")
                        });
                    }
                });
            })

</script> --}}
@endsection