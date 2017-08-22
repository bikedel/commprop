
@extends('dashboard.dashboard')

<style>
table,tr,td {

  background-color: white !important;
}
.map {
position:relative;
margin-left:-40;
}
</style>
@section('content')


<div id="map-canvas"  >


  <div class=" main map">
    {!! Mapper::render() !!}
  </div>
<p id="latlng"></p>

</div>



<script>
function setLatLng(str) {
   document.getElementById("latlng").innerHTML = str;
}

</script>


@endsection
