
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
                 <br>
             </div>

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
