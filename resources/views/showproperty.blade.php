
@extends('layouts.app')

<link href="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.6.3/flexslider.css" rel="stylesheet">

@section('content')



<div  class="container-fluid">
<div class="row">

	<div class="col-md-3">
	</div>
	  <div class="col-md-6">

			<h1>{{$property->title}}</h1>
			<p>{{$property->description}}</p>

			<div class="flexslider flexImg" style="width:400px;">
			  <ul class="slides">
					@foreach ($property->images as $image)

					    <li data-thumb={{ "property/" . $property->id ."/". $image->name }}>
					      <img src={{ "property/" . $property->id ."/". $image->name }} />
					    </li>


					@endforeach

			  </ul>
	         </div>


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
	<div class="col-md-3">
	</div>


</div>
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
