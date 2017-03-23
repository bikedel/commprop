@extends('layouts.app')

<style>

body {

  background-color: #6594B4 !important;
  z-index:-5;
}
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

.main {
        border: 10px solid white;
    border-radius: 0px;

padding-right: 0px !important;
padding-left: 0px!important;
}
</style>






@section('content')


<br>
<div id="map-canvas" class="container-fluid">
<div class="row">
  <div class="col-md-1">

  </div>
  <div class=" main col-sm-10">
    {!! Mapper::render() !!}
  </div>
  <div class="col-sm-1">

  </div>
  </div>
</div>




  <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.2.4.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


@endsection
