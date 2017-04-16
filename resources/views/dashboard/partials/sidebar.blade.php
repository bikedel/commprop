



<!-- Sidenav/menu -->
<nav class=" w3-sidenav w3-collapse w3-white w3-animate-left" style="z-index:3;" id="mySidenav"><br>
  <div class="w3-container ">
    <div class="w3-row w3-center">
    <br><b>
      @if (Auth::user()->avatar )
      <img src="agents/{{ Auth::user()->avatar }}" class="w3-circle w3-margin-right" style="width:86px">
      @else
      <img src="agents/avatar2.png" class="w3-circle w3-margin-right" style="width:86px">
      @endif
    </div>
    <div class="w3-row ">
    <br>
      <p style="text-align: center;">Welcome,<span><strong> {{ Auth::user()->name }}</strong></span></p>

     <!-- <a href="#" class="w3-hover-none w3-hover-text-blue w3-show-inline-block"><i class="fa fa-cog">{{ Auth::user()->getRoleName() }}</i></a> -->
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Dashboard</h5>
  </div>
  <a href="#" class="w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
  <a href="{{ url('/dashboard') }}" class="w3-padding "><i class="fa fa-users fa-fw"></i>  Overview</a>
  <a href="{{ url('/owners') }}" class="w3-padding"><i class="fa fa-eye fa-fw"></i>  Contacts</a>
  <a href="{{ url('/properties') }}" class="w3-padding"><i class="fa fa-users fa-fw"></i>  Properties</a>
    <a href="{{ url('/dashboardmap') }}" class="w3-padding"><i class="fa fa-bank fa-fw"></i>  Map</a>
<!--
  <a href="#" class="w3-padding"><i class="fa fa-bullseye fa-fw"></i>  Legal Docs</a>
  <a href="#" class="w3-padding"><i class="fa fa-diamond fa-fw"></i>  Broker Reports</a>
  <a href="#" class="w3-padding"><i class="fa fa-bell fa-fw"></i>  CRM Reports</a>
-->
  <a href="{{ url('/logs') }}" class="w3-padding"><i class="fa fa-cog fa-fw"></i>  Logs</a>
   <a href="{{ url('/home') }}" class="w3-padding"><i class="fa fa-cog fa-fw"></i>  Home</a><br><br>
</nav>


<!-- Overlay effect when opening sidenav on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>
