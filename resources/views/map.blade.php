@extends('layouts.app')

<style>

.searchbar {

    background-color: #F39C12  ;
    padding-top: 25px;
    padding-bottom: 25px;
}

.myleft {

     position:fixed;
    left:100px;
    right:-100px;

}

.area {

     font-size: 0.5em;
     font-weight: bold;
     color: #90B9B9    ;
}
.drop {
 position: relative;
  z-index: -99999;
}

.flexImg {
  width: 400px;
  margin:0 auto;
  text-align: center;
}
#map-canvas {
  width:100%;
  height:80%;
}

</style>



<link href="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.6.3/flexslider.css" rel="stylesheet">


@section('content')



<div id="map-canvas" class="container-fluid">
<div class="row">
  <div class="col-md-2">

  </div>
  <div class="col-sm-8">
    {!! Mapper::render() !!}
  </div>
  <div class="col-sm-2">

  </div>
  </div>
</div>







@endsection
