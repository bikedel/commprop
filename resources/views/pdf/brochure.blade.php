
<!DOCTYPE html>
<html>
<head>
<title>{{$item->title}}</title>
<link href='http://fonts.googleapis.com/css?family=Fira Sans' rel='stylesheet' type='text/css'>
<link href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css' rel='stylesheet' type='text/css'>

<style>
body{
    font-family: 'Fira Sans';
font-size: 1em;
padding:5px;
}

h1 {
    font-family: 'Fira Sans';
    font-size: 3.5em; /* 40px/16=2.5em */
}

h2 {
    font-family: 'Fira Sans';
    font-size: 2.875em; /* 30px/16=1.875em */
}

p {
    font-family: 'Fira Sans';
    font-size: 2em; /* 14px/16=0.875em */
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
        border-style: solid !important;
    border-color: #333;
     font-size:0.95em;
     padding:5px;
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
</style>

</head>

<div class="myc page">




<img src = "{{public_path()}}/img/sothebys_logo_big_blue.jpg" width="800px"/>
<br><br>

<h1> Presentation for Paul </h1>
</div>

<!--
<div class ="row    " style="margin: auto;">


         <img src = "http://maps.googleapis.com/maps/api/staticmap?size=1280x240&markers={{$item->long}},{{$item->lat}}&maptype=hybrid&scale=2&zoom=12&sensor=false" />


</div>
-->

<div class ="row  page" style="margin: auto;">


         <img src = "http://maps.googleapis.com/maps/api/staticmap?size=800x600&markers={{$item->long}},{{$item->lat}}&maptype=hybrid&scale=2&zoom=15&sensor=false&label=Hello"  alt='Google Map'/>


</div>





<div class="container-fluid">
<header><h1>{{$item->title}}</h1></header>
<h2> {{$areas[$item->area_id-1]->name}} </h2>

<p> {{$item->description}} </p>




             <div class="page">
               @if (sizeof($item->images)>0)
                 <img src="{{public_path()}}/property/{{$item->id}}/{{$item->images[0]->name}}" width="600"  class='prop_img '><br><br>
               @endif

               @if (sizeof($item->images)>1)
                 <img src="{{public_path()}}/property/{{$item->id}}/{{$item->images[1]->name}}" width="600"  class='prop_img '>
                @endif

             </div>

             <br>
             <h1>Details</h1>
             <br>
             <div >

                 <br>


                     <table  class="table  table-bordered">

                     <tbody>
                     <tr>
                         <td class="fieldname" width="350"><p>Type </p>  </td>
                         <td  width="300"><p>{{ $item->type }}</p></td>
                     </tr>
                     <tr>
                         <td class="fieldname" ><p>Status   </p></td>
                         <td ><p>{{ $item->status }}</p></td>
                     </tr>
                     <tr>
                         <td class="fieldname" ><p>Grade  </p> </td>
                         <td ><p>{{ $item->grade }}</p></td>
                     </tr>
                     <tr>
                         <td class="fieldname"><p>Erf Size  </p> </td>
                         <td ><p>{{ $item->erf_size }}</p></td>
                     </tr>
                     <tr>
                         <td class="fieldname" width="100"><p>Building Size   </p></td>
                         <td ><p>{{ $item->building_size }}</p></td>
                     </tr>
                     <tr>
                         <td class="fieldname" width="100"><p>Land Size  </p> </td>
                         <td ><p>{{ $item->land_size }}</p></td>
                     </tr>
                     <tr>
                         <td class="fieldname" width="100"><p>Covered Parking </p>  </td>
                         <td ><p>{{ $item->covered_parking_bays }}</p></td>
                     </tr>
                     <tr>
                         <td class="fieldname" width="100"><p>Open Parking  </p> </td>
                         <td ><p>{{ $item->open_parking_bays }}</p></td>
                     </tr>
                     </tbody>
                     </table>
             </div>
<br><br>
                                  <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="300" class="hidden-xs"><p>Unit ID</p></th>
                                                <th width="300" ><p>Type</p></th>
                                                <th width="220"><p>Size</p></th>
                                                <th width="220"><p>Price</p></th>


                                            </tr>
                                        </thead>
                                        <tbody>

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


                                      @endforeach
                                      </tbody>
                                      </table>


</div>



</body>
</html>
