@extends('layouts.app')

<style>

.searchbar {
    position:relative;
    top:-22px;
    background-color: #F39C12  ;
    padding-top: 45px;
    padding-bottom: 45px;
}

.myleft {

     position:fixed;
    left:100px;


}

.area {

     font-size: 0.4em;

     color: #90B9B9    ;
}

.results {
    float: right;
}

.results span {
   color:green;
   font-size: 0.8em;
}

.prop_img {
   float:left;
   padding:1px;
   border:0.2px solid #F1E6EA;
   background-color:#F1F0F0;
}


.padd {

   margin-right:20px;
}

.units {

    clear:both;

}



.border1 {
   padding:8px;
   border:1px solid #021a40;
   background-color:#fff;

}

table {
   font-size: 0.9em;

}



</style>


@section('content')


<div class="container-fluid searchbar">

 <div class="col-md-12 col-md-offset-1">
     {!!Form::open(array('method' =>'POST','route'=>'propsearch')) !!}

  <div class="form-group ">

<form class="form-inline">



    <div class="row">

   <label>
    <select name="area" id="area" class="form-control " >
            <option value="0"> All Areas </option>
            @foreach($areas as $area)
                @if ($select_area == $area->id)
                   <option value=" {{ $area->id}}" selected>  {{ $area->name}} </option>
                @else
                    <option value=" {{ $area->id}}"> {{ $area->name}} </option>
                @endif
            @endforeach

           </select>
    </label>


    <label>
        <select name="stype" id="stype" class="form-control ">
            <option value="0"> To Let or Rent </option>
            @foreach($stypes as $stype)
                 @if ($select_stype == $stype->id)
                   <option value=" {{ $stype->id}}" selected>  {{ $stype->name}} </option>
                @else
                    <option value=" {{ $stype->id}}"> {{ $stype->name}} </option>
                @endif
            @endforeach

           </select>
    </label>






    <label>
        <select name="ptype" id="ptype" class="form-control " >
            <option value="0"> All Types </option>
            @foreach($ptypes as $ptype)
                @if ($select_ptype == $ptype->id)
                   <option value=" {{ $ptype->id}}" selected>  {{ $ptype->name}} </option>
                @else
                    <option value=" {{ $ptype->id}}"> {{ $ptype->name}} </option>
                @endif

            @endforeach

           </select>
    </label>

  <label>
        <input type="text" class="form-control " id="minsize"  value="{{ $select_minsize }}" name="minsize" placeholder="Min Size" style="width: 120px;">
  </label>

  <label>
        <input type="text" class="form-control " id="maxsize"   value="{{ $select_maxsize }}" name="maxsize" placeholder="Max Size" style="width: 120px;">
  </label>

  <label>
    {!! Form::submit('Search',
      array('class'=>'btn btn-primary')) !!}
</label>
{!! Form::close() !!}

 </div>
</div>
 </div>
</div>

 <div class="container">
{{ $properties->appends(Request::except('page'))->render() }}


@if ( ! empty($search) )
<div class='results'>
Search results <span> {{ $search }} </span>
</div>

@endif


 <div class=" col-md-12 " >

    @foreach ($properties as $property)


        @if(in_array($property->area_id, (array)$area))

            <h2> {{ $property->title }}<br><p class="area">{{ $areas[$property->area_id -1]->name }}</p></h2>
        @else

            <h2> {{ $property->title }}<br><p class="area">Unknown Area</p></h2>
        @endif

        <div class=" row border" >
             <div class='prop_img col-md-3'>
                 @foreach ($property->images as $image)
                   <img src="{{asset('/property/'.$property->id.'/'.$image->name)}}" width="100%" >
                 @endforeach
             </div>



            <div class='descrip col-md-9'>
                {{ $property->description }}
            </div>

        </div>
<div class='units'>
<br>

                               <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="hidden-xs">Unit ID</th>
                                                <th>Type</th>
                                                <th>Size</th>
                                                <th>Price</th>
                                                <th></th>

                                            </tr>
                                        </thead>
                                        <tbody>

          @foreach ($property->units as $unit)



                                            <tr>
                                                <td class="hidden-xs">
                                                     Unit {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    {{ $ptypes[$unit->property_type_id -1]->name }}  {{ $stypes[$unit->sale_type_id -1]->name }}
                                                </td>
                                                <td>{{ $unit->size}}   m<sup>2</sup></td>
                                                <td>R {{ $unit->price}}  m<sup>2</sup></td>
                                                <td class="actions">
                                                    <div class="tag price pull-right" data-toggle="modal" data-target="#myModal97911" style="cursor: pointer;"><i class="fa fa-envelope"></i><span class="hidden-xs"> Unit Enquiry</span></div>
                                                </td>

                                            </tr>


          @endforeach
          </tbody>
          </table>


</div>
          <hr class="style-one">

    @endforeach

</div>

{{ $properties->appends(Request::except('page'))->render() }}



@endsection
