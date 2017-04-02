
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

h4 {
    font-family: 'Fira Sans';
    font-size: 1.5em; /* 30px/16=1.875em */
}

p {
    font-family: 'Fira Sans';
    font-size: 0.8em; /* 14px/16=0.875em */
}


.prop_img{


    border-style: solid;
    border-color: black;
    border-width: 3px 3px 3px 3px;
    border-radius: 5px;

}



table {

}


.fieldname {
    background-color: #B0C4DE;
}

th {
background-color: #B0C4DE;
    text-align: left;
}


    .page {
        overflow: hidden;
        page-break-after: always;
    }

table, tr, td, th, tbody, thead, tfoot {

     font-size:0.85em;

    page-break-inside: avoid !important;
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
    padding: 270px 0;
    }

    .bigmap{

        margin-bottom: 0;
    }

    .category {
position:relative;
display: inline-block;

padding:20px;
}

red{
    color:red;
}


.space {
    padding:5px;
}


    .page-break { display: block; page-break-before: always; }


</style>

</head>

<div class="myc page">




<img src = "{{public_path()}}/img/sothebys_logo_big_blue.jpg" width="400px"/>
<br>
<h2> Presentation</h2>
<h4>for Paul </h4>
<p>Blah blah </p>

</div>



<div class ="container-fluid  page " style="margin: auto;">

<h2> Property locations </h2>




<img align="center" src = "http://maps.googleapis.com/maps/api/staticmap?size=512x512{{$markers}}&maptype=hybrid&scale=1&sensor=false&label=Hello&key=AIzaSyCNgTdT8SN3jIzbdvZu7CBPKw3zz8J4Pww"  width="745"  class='prop_img 'alt='Google Map'/>
<br><br>

<p>{{$locations}}</p>

</div>


@foreach( $items as $item)

<div class="container-fluid page-break">


   <header><h3 style="color:navy;">{{$loop->index+1}}. Erf: {{$item->erf }} </h3><h4>{{$suburbs[$item->area_id-1]->name}}</h4></header>
<img align="center" src = "http://maps.googleapis.com/maps/api/staticmap?size=600x200&markers=color:red%7Clabel:{{$loop->index+1}}%7C{{$item->long}},{{$item->lat}}&maptype=hybrid&scale=3&sensor=false&label=Hello&key=AIzaSyCNgTdT8SN3jIzbdvZu7CBPKw3zz8J4Pww"  width="745" height="200" class='prop_img 'alt='Google Map'/>


<h4 style="color:navy;"> {{$item->title}} </h4>

<p> {{$item->description}} </p>



             <div align="center" class="category page">

               @if (sizeof($item->images)>0)
                 <img src="{{public_path()}}/property/{{$item->id}}/{{$item->images[0]->name}}" width="200"  class='prop_img '>
               @endif

               @if (sizeof($item->images)>1)
                 <img src="{{public_path()}}/property/{{$item->id}}/{{$item->images[1]->name}}" width="200"  class='prop_img '>
                @endif





             </div>

             <br>


             <div >
             <hr>

                         <td  width="300"><p>{{ $item->type }}</p></td>

                         <td ><p>{{ $item->status }}</p></td>

                         <td ><p>{{ $item->grade }}</p></td>

                         <td ><p>{{ $item->erf_size }}</p></td>

                         <td ><p>{{ $item->building_size }}</p></td>

                         <td ><p>{{ $item->land_size }}</p></td>

                         <td ><p>{{ $item->covered_parking_bays }}</p></td>

                         <td ><p>{{ $item->open_parking_bays }}</p></td>

             </div>



                                        @foreach ($item->units as $unit)



                                            <tr>
                                                <td class="hidden-xs">
                                                    <p> Unit {{ $loop->iteration }}</p>
                                                </td>
                                                <td>
                                                   <p> {{ $ptypes[$unit->property_type_id -1]->name }}  {{ $stypes[$unit->sale_type_id -1]->name }}</p>
                                                </td>
                                                <td><p>{{ $unit->size}}   m<sup>2</sup></p></td>
                                                <td><p>R {{ $unit->price}}  m<sup>2</sup></p></td>


                                            </tr>

<hr>


                                      @endforeach

@endforeach


</div>

<div align="left" class="category  page-break">
<br><br><br><br><br><br><br><br><br><br><br><br>
<h1>Disclaimer</h1>
<p>Sothebys accepts no liability for the content of this document or any attachments attached hereto, or for the consequences of any actions taken on the basis of the information provided which is provided as a rough guideline only. If you are not the intended recipient you are notified that disclosing, copying, distributing or taking any action in reliance on the contents of this information is strictly prohibited. Should this document contain property information this document shall constitute an introduction to the mentioned property. Paul shall be considered the effective cause of any transaction that comes as a result of this introduction and will be due commission on a lease at 5% of the gross value for the first two years, and 2.5% of the gross value for each following year or at 5% of the deal value on any concluded sale.</p>
</div>
</body>
</html>
