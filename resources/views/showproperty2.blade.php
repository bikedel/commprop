
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

#main {

	width: 800px;
	float: left;

}

#side {

	width: 400px;
	position: absolute;
	float:right;
	left:800px;
}

       #map {
        height: 285px;
        width: 100%;
       }

body {

	 background-color: w3-light-grey         ;

}

h4 {
    margin: 20px 10px 10px;
}
p {
    margin: 0px;
}



#carousel-custom {
    margin: 20px auto;
    width: 400px;
}
#carousel-custom .carousel-indicators {
    margin: 4px 0 0;
    overflow: auto;
    position: static;
    text-align: left;
    white-space: nowrap;
    width: 100%;
}
#carousel-custom .carousel-indicators li {
    background-color: transparent;
    -webkit-border-radius: 0;
    border-radius: 0;
    display: inline-block;
    height: auto;
    margin: 0 !important;
    width: auto;
}
#carousel-custom .carousel-indicators li img {
    display: block;
    opacity: 0.5;
    filter:blur(2px);
}
#carousel-custom .carousel-indicators li.active img {
    opacity: 1;
    filter:blur(0px);
}
#carousel-custom .carousel-indicators li:hover img {
    opacity: 0.75;
    filter:blur(0px);
}
#carousel-custom .carousel-outer {
    position: relative;
}

.camera {
     position: relative;
    float:left;
    left:0px;
    top:2px;
     padding:0px 5px 0px 0px;

}

/*  SECTIONS  */
.section {
	clear: both;
	padding: 0px;
	margin: 0px;
}

/*  COLUMN SETUP  */
.col {
	display: block;
	float:left;
	margin: 1% 0 1% 1.6%;
}
.col:first-child { margin-left: 0; }

/*  GROUPING  */
.group:before,
.group:after { content:""; display:table; }
.group:after { clear:both;}
.group { zoom:1; /* For IE 6/7 */ }
/*  GRID OF TWO  */
.span_2_of_2 {
	width: 100%;
}
.span_1_of_2 {
	width: 49.2%;
}

/*  GO FULL WIDTH AT LESS THAN 480 PIXELS */

@media only screen and (max-width: 480px) {
	.col {
		margin: 1% 0 1% 0%;
	}
}

@media only screen and (max-width: 480px) {
	.span_2_of_2, .span_1_of_2 { width: 100%; }
}

.lnk:hover {
    background-color: #92B6D5;
}
</style>


<aside id="side" >
	<div id="map" class="w3-border w3-border-red w3-topbar w3-padding-large">
	</div>

	<div class="w3-padding-large">
	</div>

	<div class=" w3-white w3-border w3-border-blue w3-topbar w3-padding-large">
		@if( isset($suburbs[$property->area_id]))
	    	<p>{{$suburbs[$property->area_id]->name}}</p>
		@endif
	</div>


	<div class=" w3-padding-large">
	</div>

	<div class=" w3-white w3-border w3-border-green w3-topbar w3-padding-large">
	<p>{{$areas[$suburbs[$property->area_id]->area_id]->name}}</p>
	</div>



	<div class=" w3-white w3-border w3-border-red w3-topbar w3-padding-large">
         @foreach ($suburbs  as $suburb)
	         @if ($suburb->area_id == $suburbs[$property->area_id]->area_id)
	        	 <p class="lnk">{{$suburb->name}}</p>
	         @endif
         @endforeach
	</div>

		<div class="  w3-padding-large">
	</div>



</aside>

<div id="main">

<div class="col-md-10 col-md-offset-1 w3-white w3-border w3-border-red w3-topbar w3-padding-large">


			<h2>{{$property->title}}</h2>
            <p> <a href="{{'gotoProperty'.$property->id}}" class="camera"> <span class="glyphicon glyphicon-map-marker"></span></a></p>
            <div class="w3-text-blue">
            <p> {{$property->address }}</p>
            </div>

	         <h3>Property Description</h3>
			<div style="height:105px;width:100%;border:0px solid #ccc;overflow:auto; padding:0px">
			<p>{{$property->description}}</p>
			</div>
            <!-- <p> {{$property->address }}</p> -->
</div>

<div class="col-md-10 col-md-offset-1  w3-padding-large">
			<div id='carousel-custom' class='carousel slide w3-border w3-border-dark-grey w3-leftbar w3-rightbar w3-bottombar w3-topbar' data-ride='carousel'>
			    <div class='carousel-outer'>
			        <!-- Wrapper for slides -->
			        <div class='carousel-inner'>
			        @foreach ($property->images as $image)
			            @if ( $loop->index == 0 )
			            <div class='item active'>
			                <img src='{{ "property/" . $property->id ."/". $image->name }}' alt='' />
			            </div>
			            @else
			            <div class='item'>
			                <img src='{{ "property/" . $property->id ."/". $image->name }}' alt='' />
			            </div>
			            @endif

			        @endforeach

			        </div>

			        <!-- Controls -->
			        <a class='left carousel-control' href='#carousel-custom' data-slide='prev'>
			            <span class='glyphicon glyphicon-chevron-left'></span>
			        </a>
			        <a class='right carousel-control' href='#carousel-custom' data-slide='next'>
			            <span class='glyphicon glyphicon-chevron-right'></span>
			        </a>
			    </div>

			    <!-- Indicators -->
			    <ol class='carousel-indicators mCustomScrollbar'>

			            @foreach ($property->images as $image)
			            @if ( $loop->index == 1 )
			                <li data-target='#carousel-custom' data-slide-to='{{$loop->index}}' class='active'><img src='{{ "property/" . $property->id ."/t_". $image->name }}' alt='' /></li>
			            @else
			                <li data-target='#carousel-custom' data-slide-to='{{$loop->index}}' class=''><img src='{{ "property/" . $property->id ."/t_". $image->name }}' alt='' /></li>
			            @endif

			        @endforeach

			    </ol>
			</div>
</div>

<div class="col-md-10 col-md-offset-1 w3-white w3-border w3-border-blue w3-leftbar w3-padding-large">

  <ul class="nav nav-tabs ">
    <li class="active"><a data-toggle="tab" href="#details">ID: <b>{{$property->id }}</b></a></li>
    <li><a data-toggle="tab" href="#notes">Notes</a></li>
    <li><a data-toggle="tab" href="#contacts">Contacts</a></li>
  </ul>

  <div class="tab-content w3-white">
    <div id="details" class="tab-pane fade in active " style="overflow-x:auto;width:100%;height:220px; ">
                  <h3>Details</h3>

					<div class="section group">
						<div class="col span_1_of_2">
						    <p>Erf: <b> {{ $property->erf }}</b></p>
						    <p>Type: <b> @if($property->type == 0) Freehold @else  Sectional Title  @endif</b></p>
						    <p>Status: <b>     @if ($property->sale_type_id>0) {{ $stypes[$property->sale_type_id]->name }}    @endif </b></p>
						    <p>Grade: <b>  @if ($property->grade_id>0) {{ $grades[$property->grade_id]->name }}   @endif </b></p>
						</div>
						<div class="col span_1_of_2">
						    <p>Erf Size: <b> {{ $property->erf_size }} m<sup>2</sup></b></p>
						    <p>Building Size: <b> {{   $property->building_size }} m<sup>2</sup></b></p>
						    <p>Open Parking: <b> {{ $property->open_parking_bays }} </b></p>
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
       @if ($owner->unit_id == 0  )

                <div class="w3-col s12 ">
                  @if ( isset($contacts[$owner->contact_id]))
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
				  @endif
				</div>

       @endif
      @endforeach
    </div>

  </div>
 </div>


<div class="col-md-10 col-md-offset-1 w3-padding-large">
</div>



<div class="col-md-10 col-md-offset-1 w3-border w3-border-grey w3-leftbar w3-white w3-padding-large">

    <p class="w3-text-blue">This property has {{$property->units->count()}} units.</p>



                <div class="w3-padding">
				    <button class="btn btn-primary " type="button"><span class="badge">{{$stat1}}</span>  </button> Vacant
                </div>
                <div class="w3-padding">
				    <button class="btn btn-success" type="button"><span class="badge">{{$stat2}}</span>  </button> Owner Occupied
				</div>
				<div class="w3-padding">
				    <button class="btn btn-warning" type="button"><span class="badge">{{$stat3}}</span>  </button> Tenant Occupied
				</div>
				<div class="w3-padding">
				    <button class="btn btn-danger" type="button"><span class="badge">{{$stat4}}</span>  </button> Govt/Provincial
				</div>


</div>

<div class="col-md-10 col-md-offset-1 w3-padding-large">
</div>


<div class="col-md-10 col-md-offset-1 w3-white w3-border w3-border-green w3-leftbar w3-padding-large">

@foreach ($property->units as $unit)


  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home{{$unit->id}}">Unit:<b>{{$unit->id}}</b></a></li>
    <li><a data-toggle="tab" href="#menu1{{$unit->id}}">Notes</a></li>
    <li><a data-toggle="tab" href="#menu2{{$unit->id}}">Contacts</a></li>

  </ul>

  <div class="tab-content w3-white">
    <div id="home{{$unit->id}}" class="tab-pane fade in active" style="overflow-x:auto;width:100%;height:300px; ">
    @if($stypes[$unit->sale_type_id]->name == 'To Let')
      <h3 class="w3-text-blue"> {{$unit->size}} m<sup>2</sup> | {{$ptypes[$unit->property_type_id]->name}} {{$stypes[$unit->sale_type_id]->name}} | R {{ number_format($unit->gross_rental,2) }} Per m<sup>2</sup></h3>
    @else
       <h3 class="w3-text-blue"> {{$unit->size}} m<sup>2</sup> | {{$ptypes[$unit->property_type_id]->name}} {{$stypes[$unit->sale_type_id]->name}} | R {{ number_format($unit->price,2) }} </h3>
    @endif
		<div class="section group">
			<div class="col span_1_of_2">
				<p>Section: <b> {{$unit->section}} </b></p>
				<p>Type: <b> {{$ptypes[$unit->property_type_id]->name}} {{$stypes[$unit->sale_type_id]->name}}</b></p>
				<p>Status: <b> {{$statuses[$unit->status_id]->name}}</b></p>
				<p>Size: <b> {{$unit->size}} m<sup>2</sup></b></p>
		        <p>Deposit: <b> {{$unit->deposit}} </b></p>
				<p>Price: <b> R {{ number_format($unit->price,2)}}</b></p>
				<p>Gross Rental: <b> R {{ number_format($unit->gross_rental,2) }} /m<sup>2</sup></b></p>
			</div>
			<div class="col span_1_of_2">
				<p>Net Rental: <b> {{$unit->net_rental}} </b></p>
				<p>Ops Costs: <b> {{$unit->ops_costs}} </b></p>
				<p>Lease start: <b> {{$unit->lease_start}}</b></p>
				<p>Lease end: <b> {{$unit->lease_end}}</b></p>
                @if (isset($agents[$unit->active_broker_id]))
			      <p>Active Broker: <b> {{$agents[$unit->active_broker_id]->name}}</b></p>
			    @endif
			   @if (isset($agents[$unit->listing_broker_id]))
			      <p>Listing Broker: <b> {{$agents[$unit->listing_broker_id]->name}}</b></p>
				@endif
			</div>
		</div>




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
       @if ($owner->unit_id == $unit->id  )


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

<script>
// Can also be used with $(document).ready()
$(window).load(function() {
   //$(".mCustomScrollbar").mCustomScrollbar({axis:"x"});
   var indicatorPosition = 0;
$('#carousel-custom').on('slid.bs.carousel', function() {

    var widthEstimate = -1 * $(".carousel-indicators li:first").position().left + $(".carousel-indicators li:last").position().left + $(".carousel-indicators li:last").width();
    var newIndicatorPosition = $(".carousel-indicators li.active").position().left + $(".carousel-indicators li.active").width() / 2;
    var toScroll = newIndicatorPosition + indicatorPosition;
    var adjustedScroll = toScroll - ($(".carousel-indicators").width() / 2);
    if (adjustedScroll < 0)
        adjustedScroll = 0;

    if (adjustedScroll > widthEstimate - $(".carousel-indicators").width())
        adjustedScroll = widthEstimate - $(".carousel-indicators").width();

    $('.carousel-indicators').animate({ scrollLeft: adjustedScroll }, 800);

    indicatorPosition = adjustedScroll;
});
});
</script>
    <script>
      function initMap() {
        var lat = <?php echo $property->lat; ?> ;
        var long = <?php echo $property->long; ?> ;
        var uluru = {lat: long, lng: lat};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 14,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNXNSQD49r8fdL-d4RNs4MmWhZue_iAyM&callback=initMap">
    </script>



@endsection
