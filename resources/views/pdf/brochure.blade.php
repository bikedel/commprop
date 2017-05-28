
<!DOCTYPE html>
<html>
<head>
<title>Brochure</title>
<link href='http://fonts.googleapis.com/css?family=Fira Sans' rel='stylesheet' type='text/css'>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style>
body{
    font-family: 'Fira Sans';
font-size: 1.6em;

}

h1 {
    font-family: 'Fira Sans';
    font-size: 2em; /* 40px/16=2.5em */
}

h2 {
    font-family: 'Fira Sans';
    font-size: 1.875em; /* 30px/16=1.875em */
}

h3,h4 {
    font-family: 'Fira Sans';
    font-size: 1.1em; /* 30px/16=1.875em */
}
h5 {
    font-family: 'Fira Sans';
    font-size: 0.8em; /* 30px/16=1.875em */
    margin-top: 0 !important;
    margin-bottom: 0!important;
}

p {
    font-family: 'Fira Sans';
    font-size: 0.8em; /* 14px/16=0.875em */
}

.pmap {
    font-family: 'Fira Sans';
    font-size: 0.8em; /* 14px/16=0.875em */
}

.prop_img{


    border-style: solid;
    border-color: lightgrey;
    border-width: 0px 0px 0px 0px !important;

    padding:0px !important;

}



table {

}


.fieldname {
    background-color: #B0C4DE;
}

th {

    text-align: left;
}


    .page {
        overflow: hidden;
        page-break-after: always;
    }

table, tr, td, th, tbody, thead, tfoot {

     font-size:0.98em;

    page-break-inside: avoid !important;
    padding:4px !important;
}

th {
         font-size:0.98em !important;

     background-color: #9EB9D4;
}


.headergrey{

  background-color: Gainsboro;
}

 .flexme{
      display: -webkit-box;
      display: -moz-box;
      display: -ms-flexbox;
      display: -webkit-flex;
      display: flex;
    }

.container{
    display: flex;
    justify-content: center;
    align-items: center;
}
    #header, #footer {
        width:100%;
        float:left;
        bottom: 0;
    }

    .myc {
    display: block;
    margin-left: auto;
    margin-right: auto;
    text-align: center;
    padding: 200px 0;
    }

    .bigmap{
        margin-top: 0;
        margin-bottom: 0;
    }

    .category {
position:relative;
display: inline-block;

padding:0px;
}

.red{
    color:red;
}


.space {
    padding:5px;
}

.brief
{

    padding:10px 100px 10px 100px;
}
.disclaimer
{

    padding:10px 10px 10px 10px;
}
    .page-break { display: block; page-break-before: always; }


.container-fluid {
  padding-right: 15px;
  padding-left: 15px;
  margin-right: auto;
  margin-left: auto;

}
.maprow {
  margin-right: -15px;
  margin-left: -15px;
  margin-top:-15px;
  top:0px !important;
}

.borderless td, .borderless th {
    border: none;
}

.avoidPageBreak {
   page-break-inside: avoid !important;
}


</style>

</head>

<div class="myc page">




<img src = "{{public_path()}}/img/sothebys_presentation_logo.png" width="800" />
<br><br>
<h5> PRESENTATION FOR:</h5>
<h4>{{$client}} </h4>
<br>
<h5> CLIENT BRIEF:</h5>
<div class="brief">
<h4>{{$brochure_text}} </h4>
</div>

</div>



<div class ="container  page " >


<div class="maprow">
<img align="center" src = "http://maps.googleapis.com/maps/api/staticmap?size=640x640&zoom={{$zoom}}{{$markers}}&maptype=hybrid&scale=2&sensor=false&label=Hello&key=AIzaSyCNgTdT8SN3jIzbdvZu7CBPKw3zz8J4Pww"  width="800" height="650" class='bigmap 'alt='Google Map'/>
</div>
<br>


    <div class="w3-row ">
    @foreach( $locations as $loc)



        @if (file_exists(public_path('/img/marker'.($loop->index+1).'.png')))
         <div class="w3-container w3-third ">  <img src="{{public_path('/img/marker'.($loop->index+1).'.png')}}"  width="30px"> {{$loc}}</div>
        @else
         <div class="w3-container w3-third "> <img src="{{public_path('/img/marker.png')}}"  width="30px" >  {{$loc}}</div>
        @endif

            @if ($loop->iteration % 2 == 0)
                </div>
                <div class="w3-row ">
            @endif

    @endforeach
    </div>
</div>






@foreach( $items as $item)

<div class="container-fluid page-break">


   <header><h4 class=""><img src="{{public_path('/img/marker'.($loop->index+1).'.png')}}"   width="30px" > {{$item->address }} </h4></header>
   <!-- <h4>{{$suburbs[$item->area_id]->name}}</h4> -->
<img align="center" src = "http://maps.googleapis.com/maps/api/staticmap?size=740x200&zoom=16&markers=label:{{$loop->index+1}}%7C{{$item->long}},{{$item->lat}}&maptype=hybrid&scale=2&sensor=false&label=Hello&key=AIzaSyCNgTdT8SN3jIzbdvZu7CBPKw3zz8J4Pww"  width="740" height="200" class='prop_img 'alt='Google Map'/>

             <div align="center" class="category page">
            <br>
               @if (sizeof($item->images)>0)
                 <img src="{{public_path()}}/property/{{$item->id}}/{{$item->images[0]->name}}" style="width:181px"   class='prop_img '>
               @endif

               @if (sizeof($item->images)>1)
                 <img src="{{public_path()}}/property/{{$item->id}}/{{$item->images[1]->name}}" style="width:181px"   class='prop_img '>
                @endif

               @if (sizeof($item->images)>2)
                 <img src="{{public_path()}}/property/{{$item->id}}/{{$item->images[2]->name}} " style="width:181px"  class='prop_img '>
                @endif

               @if (sizeof($item->images)>3)
                 <img src="{{public_path()}}/property/{{$item->id}}/{{$item->images[3]->name}} " style="width:181px"   class='prop_img '>
                @endif


             </div>
<h4 class="w3-text-blue"> {{$item->title}} </h4>

<p> {{$item->description}} </p>



<div class="w3-row ">

  <div class="w3-col s3 w3-blue-grey w3-center">
      <p><b>Id:</b>
  </div>
  <div class="w3-col s3 w3-blue-grey w3-center">
      <p><b>Type:</b></p>
  </div>
  <div class="w3-col s3 w3-blue-grey w3-center">
      <p><b>Status:</b></p>
  </div>
  <div class="w3-col s3 w3-blue-grey w3-center">
      <p><b>Grade:</b></p>
  </div>

</div>


<div class="w3-row ">

  <div class="w3-col s3 w3-lightgray w3-center">
           <p> {{ $item->id }}</p>
  </div>
  <div class="w3-col s3 w3-lightgray w3-center">
                        @if($item->type == 0)
                            <p>Freehold</p>
                         @else
                             <p>Sectional Title</p>
                         @endif
  </div>
  <div class="w3-col s3 w3-lightgray w3-center">
                         @if ($item->sale_type_id>0)
                         <p>{{ $stypes[$item->sale_type_id]->name }}</p>
                         @else
                         <p></p>
                         @endif
  </div>

  <div class="w3-col s3 w3-lightgray w3-center">
                       @if ($item->grade_id>0)
                      <p>{{ $grades[$item->grade_id]->name }}</p>
                         @else
                         <p></p>
                         @endif
  </div>

</div>




<div class="w3-row ">

  <div class="w3-col s3 w3-blue-grey w3-center">
        <p><b>Erf Size:</b>
  </div>
  <div class="w3-col s3 w3-blue-grey w3-center">
        <p><b>Building Size:</b></p>
  </div>
  <div class="w3-col s3 w3-blue-grey w3-center">
        <p><b>Open Parking:</b>
  </div>
  <div class="w3-col s3 w3-blue-grey w3-center">
        <p><b>Covered Parking:</b>
  </div>

</div>

<div class="w3-row ">
  <div class="w3-col s3 w3-lightgray w3-center">
           <p>{{ $item->erf_size }} m<sup>2</sup></p>
  </div>
  <div class="w3-col s3 w3-lightgray w3-center">
        <p>{{   $item->building_size }} m<sup>2</sup></p>
  </div>
  <div class="w3-col s3 w3-lightgray w3-center">
           <p>{{ $item->open_parking_bays }} </p>
  </div>
  <div class="w3-col s3 w3-lightgray w3-center">
           <p>{{ $item->covered_parking_bays }} </p>
  </div>


<br>

</div>

<div>
@if(strlen($note)>0 )
 <h5 class="w3-text-red">Notes:</h5> <p class="w3-text-blue">{{$note}} </p>
@endif
</div>






@foreach ($item->units as $unit)

<div class="avoidPageBreak">

  <div class="w3-row ">

    <div class="w3-col s1 w3-dark-grey w3-center">
          <p><b>Unit: </b> </p>
    </div>
    <div class="w3-col s4 w3-grey w3-center">
          <p><b>Section:</b> </p>
    </div>
    <div class="w3-col s7 w3-grey w3-center">
          <p><b>Description: </b> </p>
    </div>

  </div>

  <div class="w3-row ">

    <div class="w3-col s1 w3-lightgray w3-center">
          <p>{{ $loop->iteration }}</p>
    </div>
    <div class="w3-col s4 w3-lightgray w3-center">
        <p> {{ $unit->section }}</p>
    </div>
    <div class="w3-col s7 w3-lightgray w3-center">
          <p>{{ $unit->description }}</p>
    </div>

  </div>


  <div class="w3-row ">

      <div class="w3-col s6 headergrey w3-center">
          <p><b>Type:</b> </p>
    </div>
      <div class="w3-col s3 headergrey w3-center">
          <p><b>Size:</b>  </p>
    </div>
    @if ($unit->sale_type_id == 2)
        <div class="w3-col s3 headergrey w3-center">
            <p><b>Gross Rental:</b>  </p>
        </div>
    @else
        <div class="w3-col s3 headergrey w3-center">
            <p><b>Price:</b>  </p>
        </div>
    @endif

  </div>



  <div class="w3-col s6 w3-lightgray w3-center">
      <p>
      @if ($unit->property_type_id>0)
           {{ $ptypes[$unit->property_type_id]->name  }}
      @endif
      @if ($unit->sale_type_id>0)
          {{ $stypes[$unit->sale_type_id]->name  }}
      @endif
      </p>
    </div>
    <div class="w3-col s3 w3-lightgray w3-center">
       <p>{{ $unit->size}} m<sup>2</sup></p>
    </div>
    <div class="w3-col s3 w3-lightgray w3-center">
      @if ($unit->sale_type_id == 2)
          <p>   R {{ $unit->gross_rental}}  / m<sup>2</sup></p>
      @else
          <p>  R {{ number_format($unit->price,2)}}</p>
      @endif
    </div>

  </div>





@endforeach
</div>
</div>
@endforeach
</div>



<div align="left" class="category  page-break disclaimer">
<br><br><br><br><br><br><br><br><br><br><br><br>
<h1>Disclaimer</h1>
<p>Lew Geffen - Sotheby's International Realty accepts no liability for the content of this document or any attachments attached hereto, or for the consequences of any actions taken on the basis of the information provided which is provided as a rough guideline only. If you are not the intended recipient you are notified that disclosing, copying, distributing or taking any action in reliance on the contents of this information is strictly prohibited. Should this document contain property information this document shall constitute an introduction to the mentioned property. Each office is independantly owned and operated. Lew Geffen - Sotheby's International Realty shall be considered the effective cause of any transaction that comes as a result of this introduction and will be due commission on a lease at 5% of the gross value for the first two years, and 2.5% of the gross value for each following year or at 5% of the deal value on any concluded sale.</p>
</div>
</body>
</html>
