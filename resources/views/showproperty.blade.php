
@extends('layouts.app')

<link href="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.6.3/flexslider.css" rel="stylesheet">

@section('content')

<style type="text/css">

/*
   tr:nth-child(even){background-color: #f2f2f2}
   tr:nth-child(odd){background-color: #ECF2F9}
*/
.fred{

    background-color: lightblue;
    color:white;
}

body {

	 background-color: #E9F7EF      ;
}

input:-webkit-autofill {
    -webkit-box-shadow: 0 0 0px 1000px #ffffff inset!important;
}

    table
    {
      table-layout:fixed;
    }

    th {

        color:black;
    }

    table td  {
        padding: 5px;
        text-overflow: ellipsis;
        max-width:1500px;
        overflow:hidden;
        white-space:nowrap;
    }

    .newAgent{
          border-color: black !important;
          color:red;
    }

    .table-bordered td, .table-bordered th{
        border-color: black !important;
    }

    .slategrey-background {
      background-color: #D9E3EE;
    }

.modal-header {
    background-color: #008DB7;
}

.modal-body {
   background-color: WhiteSmoke ;
}

.modal-title {

color:white;
}

#custom-search-input {
        margin:0;
        margin-top: 10px;
        padding: 0;
    }

    #custom-search-input .search-query {
        padding-right: 3px;
        padding-right: 4px \9;
        padding-left: 3px;
        padding-left: 4px \9;
        /* IE7-8 doesn't have border-radius, so don't indent the padding */

        margin-bottom: 0;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
    }

    #custom-search-input button {
        border: 30;
        background: #008DB7;
        /** belows styles are working good */
        padding: 6px 8px;
        margin-top: 1px;
        position: relative;
        left: 2px;
        /* IE7-8 doesn't have border-radius, so don't indent the padding */
        margin-bottom: 0;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        color: white;
    }

    .search-query:focus + button {
        z-index: 8;
    }

pre {
    display: block;
    height:200px;

                font-family: 'Lato';
    white-space: pre;
    margin: 1em 0;
}

[v-cloak] { display: none; }

.searchbar {
    position:relative;
    top:-22px;

    background-color: #6594B4  ;
    padding-top: 45px;
    padding-bottom: 45px;
    z-index:auto !important;
}



.total {
    position:relative;
    float:left;
    margin-right:40px;
    left:20px;
}

.newprop {

    position:relative;
    float:right;
    margin-left:20px;
}

.hide {
     display: none;
}


.items{


     padding:20px;


}
div.myprop {
  transition: background-color 0.5s ease;

}
div.myprop:hover {
  background-color: #F6F9FC;
}

red {

    color:red;
    font-weight:bold;
}
blue {

    color:black;
    font-weight:bold;
}
small {

    color:#ccc  !important;
}
.myBtnColor,
.myBtnColor a {
  color: #fff !important;
  background-color: #F1C40F !important;
  border-color: #F1C40F !important;
}
.myBtnColor:active,
.myBtnColor.active,
.myBtnColor:focus,
.myBtnColor.focus,
.myBtnColor:hover,
.myBtnColor a:hover {

  background-color: #D4AC0D !important;
  border-color: #ccc !important;
}

.descrip {
   position:relative;
   padding-left:20px;
}


.caption {
    display: block;
    margin:0 auto;
    background: white;
    padding-left:10px;
    padding-bottom:5px;
    color: black;
    opacity: 0.2;
    position: relative;
    height:25px;
    left:0;
    bottom:0;
    top:-25px;
}



.camera {
     position: relative;
    float:right;
    left:-20px;
    top:2px;
}
#itemdetails table tbody tr td {
    border: none  !important;
       border-top: none !important;
    border-left: none !important;
    border-bottom: none !important;

}
</style>


<div  class="container-fluid">
<div class="row">

	<div class="col-md-2">
	</div>
	  <div class="col-md-6">

			<h1>{{$property->title}}</h1>
            <p> {{$areas[$property->area_id-1]->name }}</p>
            <!-- <p> {{$property->address }}</p> -->
			<div class="flexslider flexImg" style="width:600px;">
			  <ul class="slides">
					@foreach ($property->images as $image)

					    <li data-thumb={{ "property/" . $property->id ."/". $image->name }}>
					      <img src={{ "property/" . $property->id ."/". $image->name }} />
					    </li>


					@endforeach

			  </ul>
	         </div>
	         <h3>Property Description</h3>
			<div style="height:150px;width:100%;border:0px solid #ccc;overflow:auto; padding:0px">
			<p>{{$property->description}}</p>
			</div>
            <h3>Details</h3>

			             <div id="itemdetails" class=" table-responsive table-no-bordered" width="350" style="overflow-x:auto; width:350px;">
                <table  class="table table-hover  ">

                     <tbody>
                     <tr>
                         <td v-if="seen" width="150">Type   </td>
                         <td v-if="seen" width="200">{{ $property->type }}</td>
                     </tr>
                     <tr>
                         <td v-if="seen" >Status   </td>
                         <td v-if="seen">{{ $property->status }}</td>
                     </tr>
                     <tr>
                         <td v-if="seen" >Grade   </td>
                         <td v-if="seen">{{ $property->grade }}</td>
                     </tr>
                     <tr>
                         <td v-if="seen" >Erf Size   </td>
                         <td v-if="seen">{{ $property->erf_size }}</td>
                     </tr>
                     <tr>
                         <td v-if="seen" width="100">Building Size   </td>
                         <td v-if="seen">{{ $property->building_size }}</td>
                     </tr>
                                          <tr>
                         <td v-if="seen" width="100">Land Size   </td>
                         <td v-if="seen">{{ $property->land_size }}</td>
                     </tr>
                     <tr>
                         <td v-if="seen" width="100">Covered Parking   </td>
                         <td v-if="seen">{{ $property->covered_parking_bays }}</td>
                     </tr>
                     <tr>
                         <td v-if="seen" width="100">Open Parking   </td>
                         <td v-if="seen">{{ $property->open_parking_bays }}</td>
                     </tr>
                     </tbody>
                     </table>
            </div>
             <h3>Available Space</h3>
             <div class="table-responsive  " style="overflow-x:auto; ">
                <table class="table table-hover ">
                    <thead>
                         <tr>
                            <th width="80px" class="hidden-xs">Unit ID</th>
                            <th width="180px">Type</th>
                            <th width="180px">Size</th>
                            <th width="180px">Price</th>


                         </tr>
                     </thead>
                     <tbody>
                     @foreach ($property->units as $unit)
                        <tr>
                            <td class="hidden-xs">
                                Unit  {{ $unit->id }}
                            </td>
                            <td>
                                {{  $unit->property_type_id }}

                            </td>
                            <td>
                                {{ $unit->size}}   m<sup>2</sup>
                            </td>
                            <td>
                                R {{ $unit->price}}  m<sup>2</sup>
                            </td>

                        </tr>
                        @endforeach
                     </tbody>
                     </table>
                        </div>
            </div>
	<div class="col-md-4">
	</div>


</div>
<BR><BR><BR><BR><BR><BR><BR>
</div>

  <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.2.4.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.6.3/jquery.flexslider.js"></script>
<script>
// Can also be used with $(document).ready()
$(window).load(function() {
  $('.flexslider').flexslider({
    animation: "slide",
    controlNav: "thumbnails"
  });
});
</script>




@endsection
