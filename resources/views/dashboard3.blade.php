
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

  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
</head>

<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
mySidenav {

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
  <a href="{{ url('/dashboard') }}" class="w3-padding "><i class="fa fa-users fa-fw"></i>  Overview</a>
  <a href="{{ url('/owners') }}" class="w3-padding "><i class="fa fa-eye fa-fw"></i>  Contacts</a>
  <a href="{{ url('/properties') }}" class="w3-padding w3-blue"><i class="fa fa-users fa-fw"></i>  Properties</a>
    <a href="#" class="w3-padding"><i class="fa fa-bank fa-fw"></i>  Map</a>

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
    <h5><b><i class="fa fa-dashboard"></i> Properties</b></h5><br>
  </header>


 <div class="container search col-md-12 ">

<form id="search-form"  name="contact-form" action="{{route('/psearch')}}" method="get">

<!--  areas  -->
  <select name="areas[]" class="selectpicker" multiple data-width="100%" title="Please select suburb(s)">

      @foreach ($areas as $area)
            <optgroup label="{{$area->name}}">

              @foreach ($area->suburbs as $suburb)
                  <option data-content="<span class='label label-default'>{{$suburb->name}}</span>" value="{{$suburb->id}}">{{$suburb->name}}</option>
              @endforeach

            </optgroup>
      @endforeach

  </select>

<!--  prop types  -->
  <select name="ptypes[]" class="selectpicker" multiple data-width="100%" title="Please select property type(s)">


            <optgroup label="Property Types">

              @foreach ($ptypes as $ptype)
                  <option data-content="<span class='label label-info'>{{$ptype->name}}</span>"  value="{{$ptype->id}}">{{$ptype->name}}</option>
              @endforeach

            </optgroup>


  </select>


<!--  sales types  -->
  <select name="stypes[]" class="selectpicker" multiple data-width="100%" title="Please select sales type(s)">


            <optgroup label="Sales Types">

              @foreach ($stypes as $stype)
                  <option data-content="<span class='label label-success'>{{$stype->name}}</span>"  value="{{$stype->id}}">{{$stype->name}}</option>
              @endforeach

            </optgroup>


  </select>


<!--  status  -->
  <select name="status[]" class="selectpicker" multiple data-width="100%" title="Please select status(s)">


            <optgroup label="Property Status">


                  <option data-content="<span class='label label-primary'>Vacant</span>"  value="Vacant">Vacant</option>
                  <option data-content="<span class='label label-primary'>Owner occupied</span>"  value="Vacant">Owner occupied</option>
                  <option data-content="<span class='label label-primary'>Tenant occupied</span>"  value="Vacant">Tenent occupied</option>

            </optgroup>


  </select>

<!--  min  -->
  <input type="text" class="form-control" name="min" style="width:100%" placeholder="Min size">
  <!--  max  -->
  <input type="text" class="form-control" name="max" style="width:100%" placeholder="Min size">



                    <div class="form-group">
                        <br>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Search</button>
                    </div>
</form>
 <br><br>


 </div>


 <div class="container maintable col-md-12 ">

     <div class="table-responsive  " style="overflow-x:auto;width:100%; ">
                <table class="table table-bordered table-hover ">
                    <thead>
                         <tr>
                            <th width="80px" class="hidden-xs">Id</th>
                            <th width="100px">Erf</th>
                            <th width="100px">Area</th>
                            <th width="280px">Address</th>
                            <th width="180px">Title</th>
                            <th width="180px">Type</th>
                            <th width="180px">Status</th>

                         </tr>
                     </thead>
                     <tbody>
                     @foreach ($properties as $property)
                        <tr>
                            <td class="hidden-xs">
                                  {{ $property->id }}
                            </td>
                            <td>
                                {{  $property->erf }}
                            </td>
                            <td>
                                {{  $property->area_id }}
                            </td>
                            <td>
                                {{  $property->address }}
                            </td>
                            <td>
                                {{ $property->title}}
                            </td>
                            <td>
                                 {{ $property->type}}
                            </td>
                            <td>
                                {{  $property->status }}
                            </td>


                        </tr>
                        @endforeach
                     </tbody>
                     </table>
      </div>

     <div class="" style="z-index:-10 !important;float:right;">
          {{$properties->links()}}
     </div>

  </div>

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
