
<!DOCTYPE html>
<html>
<head>
<title>{{$item->title}}</title>
<style>
body{

}
.prop_img{


    border-style: solid;
    border-color: black;
    border-width: 3px 3px 3px 3px;
    border-radius: 5px;
}

table {
    border-collapse: collapse;
}




th {
    background-color:#ccc;
    text-align: left;
}

</style>

</head>


<div class="container-fluid">
<header><h1>{{$item->title}}</h1></header>
<h2> {{$areas[$item->area_id-1]->name}} </h2>

<p> {{$item->description}} </p>




             <div >
               @if (sizeof($item->images)>0)
                 <img src="{{public_path()}}/property/{{$item->id}}/{{$item->images[0]->name}}" width="200" class='prop_img '>
               @endif
               @if (sizeof($item->images)>1)
                 <img src="{{public_path()}}/property/{{$item->id}}/{{$item->images[1]->name}}" width="200" class='prop_img '>
                @endif
                 <br>
             </div>
             <div >

                 <br>


                                 <table  class="table  ">

                     <tbody>
                     <tr>
                         <td v-if="seen" width="150">Type   </td>
                         <td v-if="seen" width="200">{{ $item->type }}</td>
                     </tr>
                     <tr>
                         <td v-if="seen" >Status   </td>
                         <td v-if="seen">{{ $item->status }}</td>
                     </tr>
                     <tr>
                         <td v-if="seen" >Grade   </td>
                         <td v-if="seen">{{ $item->grade }}</td>
                     </tr>
                     <tr>
                         <td v-if="seen" >Erf Size   </td>
                         <td v-if="seen">{{ $item->erf_size }}</td>
                     </tr>
                     <tr>
                         <td v-if="seen" width="100">Building Size   </td>
                         <td v-if="seen">{{ $item->building_size }}</td>
                     </tr>
                                          <tr>
                         <td v-if="seen" width="100">Land Size   </td>
                         <td v-if="seen">{{ $item->land_size }}</td>
                     </tr>
                     <tr>
                         <td v-if="seen" width="100">Covered Parking   </td>
                         <td v-if="seen">{{ $item->covered_parking_bays }}</td>
                     </tr>
                     <tr>
                         <td v-if="seen" width="100">Open Parking   </td>
                         <td v-if="seen">{{ $item->open_parking_bays }}</td>
                     </tr>
                     </tbody>
                     </table>
             </div>
<br><br>
                                  <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="100" class="hidden-xs">Unit ID</th>
                                                <th width="300" >Type</th>
                                                <th width="120">Size</th>
                                                <th width="120">Price</th>


                                            </tr>
                                        </thead>
                                        <tbody>

                                        @foreach ($item->units as $unit)



                                            <tr>
                                                <td class="hidden-xs">
                                                     Unit {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                   <p> {{ $ptypes[$unit->property_type_id -1]->name }}  {{ $stypes[$unit->sale_type_id -1]->name }}</p>
                                                </td>
                                                <td><p>{{ $unit->size}}   m<sup>2</sup></p></td>
                                                <td>R {{ $unit->price}}  m<sup>2</sup></td>


                                            </tr>


                                      @endforeach
                                      </tbody>
                                      </table>


</div>
</body>
</html>
