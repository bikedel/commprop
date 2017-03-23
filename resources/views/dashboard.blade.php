
<!DOCTYPE html>
<html>
<title>Commprop Dashboard</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
mySidenav {
    position:absolute;
  top:-60px;
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
  <a href="{{ url('/dashboard') }}" class="w3-padding w3-blue"><i class="fa fa-users fa-fw"></i>  Overview</a>
  <a href="{{ url('/owners') }}" class="w3-padding"><i class="fa fa-eye fa-fw"></i>  Contacts</a>
  <a href="{{ url('/properties') }}" class="w3-padding"><i class="fa fa-users fa-fw"></i>  Properties</a>
    <a href="{{ url('/dashboardmap') }}" class="w3-padding"><i class="fa fa-bank fa-fw"></i>  Map</a>

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
    <h5><b><i class="fa fa-dashboard"></i> Overview</b></h5>
  </header>

  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-building w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>{{$properties->count()}}</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Properties</h4>
      </div>
    </div>
        <div class="w3-quarter">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-home w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>{{$units->count()}}</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Units</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>{{$properties->where('status','To Let')->count()}}</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>To Let</h4>
      </div>
    </div>

    <div class="w3-quarter">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-credit-card w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>{{$properties->where('status','For Sale')->count()}}</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>For Sale</h4>
      </div>
    </div>
  </div>


  <hr>

  <div class="w3-container">
    <h5>Latest Properties added</h5>
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">


    @for($x = 0; $x < 6; $x++)
          <tr>
          <td>{{ $properties[$x]->created_at->diffForHumans()}}</td>
            <td>{{$properties[$x]->title}}</td>
            <td>{{$properties[$x]->address}}</td>
            <td> <a href="{{ url('/showproperty'.$properties[$x]->id) }}" class="w3-padding"><i class="fa fa-cog fa-fw"></i>  View</a></td>

          </tr>
    @endfor


    </table>
    <!--
     <div class="" style="z-index:-10 !important;float:right;">

     </div>

     -->
    <br>


    <a href="{{ url('/home') }}" class="w3-button w3-dark-grey" role="button">Search Properties  <i class="fa fa-arrow-right"></i></a>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Recent Units added</h5>
    <ul class="w3-ul w3-card-4 w3-white">

    @for($x = 0; $x < 4; $x++)
    @if ( sizeof($properties[$x]->images) > 0 )
      <li class="w3-padding-32">
        <span onclick="this.parentElement.style.display='none'" class="w3-closebtn w3-padding w3-margin-right w3-medium">x</span>

        <img class="img-thumbnail" src="{{ 'property/' . $properties[$x]->id .'/'.  $properties[$x]->images[0]->name }}" class="w3-left  w3-margin-right" style="width:60px;height:60px;">

        <span class="w3-small">Erf: {{$properties[$x]->erf }} Unit: {{$properties[$x]->id}}
           @if ( sizeof($properties[$x]->units) > 0 )

                  Status: {{ $statuses[$properties[$x]->units[0]->status_id-1]->name}}</span>

           @endif

      </li>
      @endif
    @endfor

    </ul>
  </div>
  <hr>

  <div class="w3-container">
    <h5>Brokers</h5>
    <div class="w3-row">
      <div class="w3-col m2 text-center">
        <img class="img-thumbnail" src="agents/Jack Bass.jpg" style="width:96px;height:96px">
      </div>
      <div class="w3-col m10 w3-container">
        <h4>Jack Bass <span class="w3-opacity w3-medium"></span></h4>
        <p>Before joining the property sector, I was involved in the manufacturing, design and distribution of casual furniture and accessories in the USA. After selling my business and moving back to South Africa, I wanted a change in career and decided to give property a try and it?s a choice I?m glad I made! I specialise in industrial property in the Western Cape but I also have experience in retail, commercial and investment properties.</p><br>
      </div>
    </div>

    <div class="w3-row">
      <div class="w3-col m2 text-center">
        <img class="img-thumbnail" src="agents/Rob Odendaal.jpg" style="width:96px;height:96px">
      </div>
      <div class="w3-col m10 w3-container">
        <h4>Rob Odendaal <span class="w3-opacity w3-medium"></span></h4>
        <p>My career in property began when Tony Galetti asked me to join the company as a broker in 2006. Before becoming a broker, I was a teacher in Cape Town and I also taught in the U.K. for a while. Today, I specialise in industrial and commercial property in the Western Cape. My biggest strength lies in meeting people. I network well and build up relationships and this leads naturally to doing deals on all levels.</p><br>
      </div>
    </div>
  </div>
  <br>
  <div class="w3-container w3-dark-grey w3-padding-32">
    <div class="w3-row">
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-green">Location</h5>
        <p>Claremont Office</p>
        <p>Protea Rd, Claremont</p>
      </div>
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-red">System</h5>
        <p>OS {{$useragent }}</p>
        <p>IP {{$ip}}</p>
      </div>
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-orange">Support</h5>
        <p>User {{ Auth::user()->name }}</p>
        <p>Action Dashboard</p>


      </div>
    </div>
  </div>

  <!-- Footer
  <footer class="w3-container w3-padding-16 w3-light-grey">
    <h4>FOOTER</h4>
    <p>Powered by <a href="https://www.proteadb.co.za/commprop" target="_blank">Paul</a></p>
  </footer>
-->
  <!-- End page content -->
</div>


<script>
// Get the Sidenav
var mySidenav = document.getElementById("mySidenav");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidenav, and add overlay effect
function w3_open() {
    if (mySidenav.style.display === 'block') {
        mySidenav.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidenav.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidenav with the close button
function w3_close() {
    mySidenav.style.display = "none";
    overlayBg.style.display = "none";
}

</script>

</body>
</html>
