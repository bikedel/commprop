
<!DOCTYPE html>
<html>
<title>Commprop Dashboard</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.2.4.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</head>

<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
mySidenav {

  top:-60px;
}



body {

  background-color: #6594B4 !important;

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
  width:600px;
  height:400px;

}

.main {
        border: 10px solid white;
    border-radius: 0px;

padding-right: 0px !important;
padding-left: 0px!important;
}
</style>

<body class="w3-light-grey">
<!-- Top container -->
<div class="w3-container w3-top w3-white w3-large w3-padding" style="z-index:4">
  <button class="w3-button w3-hide-large w3-padding-0 w3-black w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <span class="w3-right"> <a class="navbar-brand logo" href="{{ url('/home') }}"><img src="img/commprop1.png" width="40px" height="40px" alt="CommProp"></span>
</div>


<!-- Sidenav/menu -->
<nav class=" w3-sidenav w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidenav"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="agents/avatar2.png" class="w3-circle w3-margin-right" style="width:46px">
    </div>
    <div class="w3-col s8">
      <span>Welcome, <strong> {{ Auth::user()->name }}</strong></span><br>
      <a href="#" class="w3-hover-none w3-hover-text-red w3-show-inline-block"><i class="fa fa-envelope"></i></a>
      <a href="#" class="w3-hover-none w3-hover-text-green w3-show-inline-block"><i class="fa fa-user"></i></a>
      <a href="#" class="w3-hover-none w3-hover-text-blue w3-show-inline-block"><i class="fa fa-cog"></i></a>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Dashboard</h5>
  </div>
  <a href="#" class="w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
  <a href="{{ url('/dashboard') }}" class="w3-padding "><i class="fa fa-users fa-fw"></i>  Overview</a>
  <a href="{{ url('/owners') }}" class="w3-padding "><i class="fa fa-eye fa-fw"></i>  Contacts</a>
  <a href="{{ url('/properties') }}" class="w3-padding "><i class="fa fa-users fa-fw"></i>  Properties</a>
    <a href="#" class="w3-padding w3-blue"><i class="fa fa-bank fa-fw"></i>  Map</a>

  <a href="#" class="w3-padding"><i class="fa fa-bullseye fa-fw"></i>  Legal Docs</a>
  <a href="#" class="w3-padding"><i class="fa fa-diamond fa-fw"></i>  Broker Reports</a>
  <a href="#" class="w3-padding"><i class="fa fa-bell fa-fw"></i>  CRM Reports</a>

  <a href="#" class="w3-padding"><i class="fa fa-cog fa-fw"></i>  Settings</a>
     <a href="{{ url('/home') }}" class="w3-padding"><i class="fa fa-cog fa-fw"></i>  Web Site</a><br><br>
</nav>


<!-- Overlay effect when opening sidenav on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div id="content" class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-map"></i> Map</b></h5><br>
  </header>


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









</body>
</html>
