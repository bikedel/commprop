
@extends('layouts.app')

<link href="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.6.3/flexslider.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Fira Sans' rel='stylesheet' type='text/css'>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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

	 background-color: w3-light-grey         ;

}

input:-webkit-autofill {
    -webkit-box-shadow: 0 0 0px 1000px #ffffff inset!important;
}

    table
    {
      table-layout:fixed;
 border-color: #ccc !important;
    }

    th {
border-color:  #ccc  !important;
        color:#999999 !important;
    }

    table td  {
    	 border-color: #ccc !important;
        padding: 5px;
        text-overflow: ellipsis;
        max-width:1500px;
        overflow:hidden;
        white-space:nowrap;
    }

    .newAgent{
          border-color: #666 !important;
          color:red;
    }

    .table-bordered td, .table-bordered th{
        border-color: #ccc !important;
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
    float:left;
    left:0px;
    top:2px;
     padding:0px 5px 0px 0px;

}
#itemdetails table tbody tr td {
    border: none  !important;
       border-top: none !important;
    border-left: none !important;
    border-bottom: none !important;

}
</style>





	  <div class="col-md-8 col-md-offset-1">




			<h2>{{$property->title}}</h2>
            <p> <a href="{{'gotoProperty'.$property->id}}" class="camera"> <span class="glyphicon glyphicon-map-marker"></span></a></p>
            <div class="w3-text-blue">
            <p> {{$property->address }}</p>
            </div>
            <img align="center" src = "http://maps.googleapis.com/maps/api/staticmap?size=600x200&zoom=15&markers=color:red%7Clabel:%7C{{$property->long}},{{$property->lat}}&maptype=hybrid&scale=3&sensor=false&label=Hello&key=AIzaSyCNgTdT8SN3jIzbdvZu7CBPKw3zz8J4Pww"  width="100%" height="200" class='prop_img 'alt='Google Map'/>
	         <h3>Property Description</h3>
			<div style="height:100px;width:100%;border:0px solid #ccc;overflow:auto; padding:0px">
			<p>{{$property->description}}</p>
			</div>
            <!-- <p> {{$property->address }}</p> -->
              <div class="w3-container">
	          <div class="w3-col s6 w3-padding">

			<div class="flexslider flexImg " >
			  <ul class="slides">
			  <?php $count = 0;?>
					@foreach ($property->images as $image)
                        <?php $count++;?>



                        @if ($count <= 4 )
                          @if  (  file_exists(public_path("property/" . $property->id ."/". $image->name)))
						    <li data-thumb={{ "property/" . $property->id ."/". $image->name }}>
						      <img src={{ "property/" . $property->id ."/". $image->name }} />
						    </li>
						  @else
						    <li data-thumb={{ "property/no_image.png" }}>
						      <img src={{  "property/no_image.png" }} />
						    </li>
						  @endif

					    @endif


					@endforeach

			  </ul>
	      </div>

	          </div>




</div>

</div>

<div class="col-md-10 col-md-offset-1">
<div class="container">
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#details">Erf: <b>{{$property->erf }}</b></a></li>
    <li><a data-toggle="tab" href="#notes">Notes</a></li>
    <li><a data-toggle="tab" href="#contacts">Contacts</a></li>
  </ul>

  <div class="tab-content">
    <div id="details" class="tab-pane fade in active " style="overflow-x:auto;width:100%;height:300px; ">
                  <h3>Details</h3>

				  <div class="w3-col s10 ">

				  <div class="w3-col s5 ">
				      <p>Erf: <b> {{ $property->erf }}</b></p>
				  </div>
				  <div class="w3-col s5 ">
				      <p>Type: <b> @if($property->type == 0) Freehold @else  Sectional Title  @endif</b></p>
				  </div>
				 </div>
				 <div class="w3-col s10 ">
				  <div class="w3-col s5 ">
				      <p>Status: <b>     @if ($property->sale_type_id>0) {{ $stypes[$property->sale_type_id]->name }}    @endif </b></p>
				  </div>
				  <div class="w3-col s5">
				      <p>Grade: <b>  @if ($property->grade_id>0) {{ $grades[$property->grade_id]->name }}   @endif </b></p>
				  </div>
				</div>
				 <div class="w3-col s10 ">
				  <div class="w3-col s5 ">
				      <p>Erf Size: <b> {{ $property->erf_size }} m<sup>2</sup></b></p>
				  </div>
				  <div class="w3-col s5">
				             <p>Building Size: <b> {{   $property->building_size }} m<sup>2</sup></b></p>
				</div>
				</div>
				 <div class="w3-col s10 ">
				  <div class="w3-col s5 ">
				    <p>Open Parking: <b> {{ $property->open_parking_bays }} </b></p>
				  </div>
				  <div class="w3-col s5">
				     <p>Covered Parking: <b> {{ $property->covered_parking_bays }} </b></p>
				  </div>
				</div>


  </div>
    <div id="notes" class="tab-pane fade" style="overflow-x:auto;width:100%;height:300px; ">
      <h3>Notes</h3>
                 <div class="w3-col s12 w3-light-grey ">
				  <div class="w3-col s2 ">
				    <p>Date</p>
				  </div>
				  <div class="w3-col s2">
				     <p>User</p>
				  </div>
				  <div class="w3-col s8">
				     <p>Note </p>
				  </div>
				</div>
      @foreach($property->notes as $note)
         @if ($note->unit_id == 0 )

         		<div class="w3-col s12 ">
				  <div class="w3-col s2">
				    <p>{{$note->created_at}}</p>
				  </div>
				  <div class="w3-col s2">
				     <p>{{$users[$note->user_id]->name }} </p>
				  </div>
				  <div class="w3-col s8">
				     <p>{{ $note->description }} </p>
				  </div>
				</div>

         <hr>
         @endif
      @endforeach


</div>


    <div id="contacts" class="tab-pane fade" style="overflow-x:auto;width:100%;height:300px; ">
      <h3>Contacts</h3>
                 <div class="w3-col s12 w3-light-grey ">
				  <div class="w3-col s2 ">
				    <p>Type</p>
				  </div>
				  <div class="w3-col s2">
				     <p>Company</p>
				  </div>
				  <div class="w3-col s2">
				     <p>Contact </p>
				  </div>
				  <div class="w3-col s2">
				     <p>Tel</p>
				  </div>
				  <div class="w3-col s2">
				     <p>Cell</p>
				  </div>
				  <div class="w3-col s2">
				     <p>Email </p>
				  </div>
				</div>

      @foreach($property->owners as $owner)
       @if ($owner->unit_id == 0 )

                <div class="w3-col s12 ">
				  <div class="w3-col s2">
				    <p>{{$contacttypes[$owner->contact_type_id]->name}}</p>
				  </div>
				  <div class="w3-col s2">
				       <p>{{ $contacts[$owner->contact_id]->company  }} </p>
				  </div>
				  <div class="w3-col s2">
				     <p>{{ $contacts[$owner->contact_id]->firstname .' '. $contacts[$owner->contact_id]->lastname }} </p>
				  </div>
				  <div class="w3-col s2">
				     <p>{{ $contacts[$owner->contact_id]->tel }}</p>
				  </div>
				  <div class="w3-col s2">
				     <p>{{ $contacts[$owner->contact_id]->cell  }} </p>
				  </div>
				  <div class="w3-col s2">
				     <p>{{ $contacts[$owner->contact_id]->email  }} </p>
				  </div>
				</div>

       @endif
      @endforeach
    </div>

  </div>
 </div>
  </div>






<div class="col-md-10 col-md-offset-1">

<div class="w3-text-blue">
 <hr>
<p >This property has {{$property->units->count()}} units.</p>
 <hr>


			  <div class="w3-col s3">
				     <p><button class="btn btn-primary" type="button"><span class="badge">{{$stat1}}</span>  </button><br> Vacant</p>
				  </div>
				  <div class="w3-col s3">
				     <p><button class="btn btn-success" type="button"><span class="badge">{{$stat2}}</span>  </button><br> Owner Occupied</p>
				  </div>
				  <div class="w3-col s3">
				     <p><button class="btn btn-warning" type="button"><span class="badge">{{$stat3}}</span>  </button><br> Tenant Occupied</p>
				  </div>
				  <div class="w3-col s3">
				     <p><button class="btn btn-danger" type="button"><span class="badge">{{$stat4}}</span>  </button><br> Govt/Provincial</p>
				  </div>
</div>
</div>


<div class="col-md-10 col-md-offset-1">
<div class="container">
@foreach ($property->units as $unit)




<hr>


  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home{{$unit->id}}">Unit:<b>{{$unit->id}}</b></a></li>
    <li><a data-toggle="tab" href="#menu1{{$unit->id}}">Notes</a></li>
    <li><a data-toggle="tab" href="#menu2{{$unit->id}}">Contacts</a></li>

  </ul>

  <div class="tab-content">
    <div id="home{{$unit->id}}" class="tab-pane fade in active" style="overflow-x:auto;width:100%;height:300px; ">
      <h3>Details</h3>
		<p>Type: <b> {{$ptypes[$unit->property_type_id]->name}} {{$stypes[$unit->sale_type_id]->name}}</b></p>
		<p>Status: <b> {{$statuses[$unit->status_id]->name}}</b></p>
		<p>Size: <b> {{$unit->size}} m<sup>2</sup></b></p>
		@if($unit->sale_type_id == 1)
		<p>Price: <b> R {{ number_format($unit->price,2)}}</b></p>
		@else
		<p>Gross Rental: <b> R {{ number_format($unit->gross_rental,2) }} /m<sup>2</sup></b></p>
		@endif
		<p>Lease start: <b> {{$unit->lease_start}}</b></p>
		<p>Lease end: <b> {{$unit->lease_end}}</b></p>
    </div>
    <div id="menu1{{$unit->id}}" class="tab-pane fade" style="overflow-x:auto;width:100%;height:300px; ">
      <h3>Notes</h3>
                 <div class="w3-col s12 w3-light-grey ">
				  <div class="w3-col s2 ">
				    <p>Date</p>
				  </div>
				  <div class="w3-col s2">
				     <p>User</p>
				  </div>
				  <div class="w3-col s8">
				     <p>Note </p>
				  </div>
				</div>
      @foreach($property->notes as $note)
         @if ($note->unit_id == $unit->id )

         		<div class="w3-col s12 ">
				  <div class="w3-col s2">
				    <p>{{$note->created_at}}</p>
				  </div>
				  <div class="w3-col s2">
				     <p><{{$users[$note->user_id]->name }} </p>
				  </div>
				  <div class="w3-col s8">
				     <p>{{ $note->description }} </p>
				  </div>
				</div>

         <hr>
         @endif
      @endforeach
    </div>
    <div id="menu2{{$unit->id}}" class="tab-pane fade" style="overflow-x:auto;width:100%;height:300px; ">
     <h3>Contacts</h3>
                 <div class="w3-col s12 w3-light-grey ">
				  <div class="w3-col s2 ">
				    <p>Type</p>
				  </div>
				  <div class="w3-col s2">
				     <p>Company</p>
				  </div>
				  <div class="w3-col s2">
				     <p>Contact </p>
				  </div>
				  <div class="w3-col s2">
				     <p>Tel </p>
				  </div>
				  <div class="w3-col s2">
				     <p>Cell</p>
				  </div>
				  <div class="w3-col s2">
				     <p>Email </p>
				  </div>
				</div>

      @foreach($property->owners as $owner)
       @if ($owner->unit_id == $unit->id )

                <div class="w3-col s12 ">
				  <div class="w3-col s2">
				    <p>{{$contacttypes[$owner->contact_type_id]->name}}</p>
				  </div>
				  <div class="w3-col s2">
				       <p>{{ $contacts[$owner->contact_id]->company  }} </p>
				  </div>
				  <div class="w3-col s2">
				     <p>{{ $contacts[$owner->contact_id]->firstname .' '. $contacts[$owner->contact_id]->lastname }} </p>
				  </div>
				  <div class="w3-col s2">
				     <p>{{ $contacts[$owner->contact_id]->tel }}</p>
				  </div>
				  <div class="w3-col s2">
				     <p>{{ $contacts[$owner->contact_id]->cell  }} </p>
				  </div>
				  <div class="w3-col s2">
                     <p><a href="mailto:{{ $contacts[$owner->contact_id]->email  }}"> {{ $contacts[$owner->contact_id]->email  }}</a></p>
				  </div>
				</div>
         <hr>
       @endif
      @endforeach
    </div>

  </div>







@endforeach
</div>
</div>
	<div class="col-md-4">
	<br><br><br><br><br><br><br><br><br><br><br><br>
	</div>

<br>
<br>
<br>
<br><br><br><br><br><br>
</div>


  <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.2.4.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
