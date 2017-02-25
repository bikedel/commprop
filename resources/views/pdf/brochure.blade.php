
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
    background-color:azure;
    text-align: left;
}

</style>

</head>


<div class="container-fluid">
<header><h1>{{$item->title}}</h1></header>
<h2> {{$areas[$item->area_id-1]->name}} </h2>

<p> {{$item->description}} </p>




             <div >
                 <img src="http://localhost/laravel/commprop/public/property/{{$item->id}}/{{$item->images[0]->name}}" width="200" class='prop_img '>
             </div>


                                  <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="200" class="hidden-xs">Unit ID</th>
                                                <th width="200" >Type</th>
                                                <th width="200">Size</th>
                                                <th width="200">Price</th>


                                            </tr>
                                        </thead>
                                        <tbody>

          @foreach ($item->units as $unit)



                                            <tr>
                                                <td class="hidden-xs">
                                                     Unit {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    {{ $ptypes[$unit->property_type_id -1]->name }}  {{ $stypes[$unit->sale_type_id -1]->name }}
                                                </td>
                                                <td>{{ $unit->size}}   m<sup>2</sup></td>
                                                <td>R {{ $unit->price}}  m<sup>2</sup></td>


                                            </tr>


          @endforeach
          </tbody>
          </table>


</div>
</body>
</html>
