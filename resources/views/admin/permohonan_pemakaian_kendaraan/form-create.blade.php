@extends('admin::layout.master')

@section('content')
<style>
	.kpi-form-header{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;margin-bottom:20px;}
	.kpi-btn-back{display:inline-flex;align-items:center;gap:8px;background:#F5F6FA;color:#1F5C85;border:none;border-radius:20px;padding:9px 20px;font-size:14px;font-weight:600;transition:background .15s,transform .15s;}
	.kpi-btn-back:hover{background:#E1EDF4;transform:translateX(-2px);color:#1F5C85;text-decoration:none;}
	.kpi-form-card{background:#fff;border:1px solid #EEF0F5;border-radius:10px;box-shadow:0 1px 3px rgba(0,0,0,0.04);padding:24px;}
</style>
@include('admin::partials.alert-messages')
<div class="kpi-form-header">
    <h2 style="margin:0;">Create Permohonan Pemakaian Kendaraan</h2>
    <a class="kpi-btn-back" href="{{ route('admin::permohonan-pemakaian-kendaraan.page-list') }}"><i class="fa fa-arrow-left"></i> Kembali</a>
</div>
<div class="kpi-form-card">
    {!! $form->render() !!}
</div>
@stop

@script
<script>
  var myLatLng = {lat: -6.1114326, lng: 106.7821099};
  var mapOptions = {
      center: myLatLng,
      zoom: 13,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
  };
  
  //create map
  var map = new google.maps.Map(document.getElementById('map-input-latlng'), mapOptions);

  //create a DirectionsRenderer object which we will use to display the route
  var directionsDisplay = new google.maps.DirectionsRenderer();

  //bind the DirectionsRenderer to the map
  directionsDisplay.setMap(map);

  //create a DirectionsService object to use the route method and get a result for our request
  var directionsService = new google.maps.DirectionsService();

  $("#input-tujuan").change(function(){
    var request = {
      origin: "Pjb Up Muara Karang Pt., Pluit, North Jakarta City, Jakarta, Indonesia",
      destination: document.getElementById("input-tujuan").value,
      travelMode: google.maps.TravelMode.DRIVING, //WALKING, BYCYCLING, TRANSIT
      unitSystem: google.maps.UnitSystem.METRIC  //METRIC, IMPERIAL
    }

    directionsService.route(request, function (result, status) {
      if (status == google.maps.DirectionsStatus.OK) {
        console.log(result)
        //remove string 
        distance = result.routes[0].legs[0].distance.text.replace(/[^0-9\.]+/g, "");
        $("#input-jarak").val(parseFloat(distance)*2)
        //display route
        directionsDisplay.setDirections(result);
      }else {
        console.log(result)
      }
    })
  })

  var mapOptions = {}
  var input2 = document.getElementById("input-tujuan");
  var autocomplete = new google.maps.places.Autocomplete(input2, mapOptions);
  var inputLatlng = document.getElementById("input-latlng");
  var INVALID_TUJUAN_MESSAGE = "Pilih salah satu lokasi tujuan dari daftar saran yang muncul.";
  var justSelectedPlace = false;

  // A valid place was picked from the Google suggestion list
  autocomplete.addListener('place_changed', function () {
    var place = autocomplete.getPlace();
    justSelectedPlace = true;

    if (!place || !place.geometry || !place.geometry.location) {
      inputLatlng.value = "";
      input2.setCustomValidity(INVALID_TUJUAN_MESSAGE);
      return;
    }

    inputLatlng.value = place.geometry.location.lat() + ',' + place.geometry.location.lng();
    input2.setCustomValidity("");
  });

  // Typing manually (not picking a suggestion) invalidates the previously confirmed location
  input2.addEventListener('input', function () {
    if (justSelectedPlace) {
      justSelectedPlace = false;
      return;
    }
    inputLatlng.value = "";
    input2.setCustomValidity(input2.value.trim().length > 0 ? INVALID_TUJUAN_MESSAGE : "");
  });

  // Safety net in case the browser lets the form through anyway
  $(input2.closest('form')).on('submit', function (e) {
    if (!inputLatlng.value) {
      e.preventDefault();
      input2.setCustomValidity(INVALID_TUJUAN_MESSAGE);
      input2.reportValidity();
      swal('Tujuan Belum Valid', 'Silakan ketik lalu pilih salah satu lokasi tujuan dari daftar saran yang muncul di peta.', 'warning');
    }
  });

// setInterval(function(){
// 	$.ajax({url: "{{url('api/biayapermeter')}}", success: function(result){
// 		jarak = $("[name='jarak']").val()
//     	total = parseFloat(jarak) * parseInt(result.value)
//     	$("[name='total_biaya']").val(total)
//   	}});
// }, 10);

$(function() {
  $("#input-latlng").on('routes', function (e, data) {
    $("#input-rute").val(JSON.stringify(data.paths));
    $("#input-jarak").val(data.distance.value / 1000);
    $("#input-lama_perjalanan").val(data.duration.value);
  });
});
</script>
@endscript