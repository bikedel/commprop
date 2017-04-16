
@extends('dashboard.dashboard')

  <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.2.4.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>

<style>
table,tr,td {

  background-color: white !important;
  font-size:.9em !important;
}
</style>

@section('content')


   <!-- Header -->
  <header class="w3-container" style="padding-top:42px">
    <h5><b><i class="fa fa-dashboard"></i> Properties</b></h5><br>
  </header>


 <div class="container search col-md-12 ">

<form id="search-form"  name="contact-form" action="{{route('/psearch')}}" method="get">

<!--  areas  -->
  <select name="areas[]" class="selectpicker" multiple data-width="100%" title="Please select suburb(s)">

      @foreach ($areas as $area)
            <optgroup label="{{$area->name}}">

              @foreach ($area->suburbs as $suburb)
                  <option data-content="<span class='label label-default'>{{$suburb->name}}</span>" value="{{$suburb->id}}">{{$suburb->name}}</option>
              @endforeach

            </optgroup>
      @endforeach

  </select>

<!--  prop types  -->
  <select name="ptypes[]" class="selectpicker" multiple data-width="100%" title="Please select property type(s)">


            <optgroup label="Property Types">

              @foreach ($ptypes as $ptype)
                  <option data-content="<span class='label label-info'>{{$ptype->name}}</span>"  value="{{$ptype->id}}">{{$ptype->name}}</option>
              @endforeach

            </optgroup>


  </select>


<!--  sales types  -->
  <select name="stypes[]" class="selectpicker" multiple data-width="100%" title="Please select sales type(s)">


            <optgroup label="Sales Types">

              @foreach ($stypes as $stype)
                  <option data-content="<span class='label label-success'>{{$stype->name}}</span>"  value="{{$stype->id}}">{{$stype->name}}</option>
              @endforeach

            </optgroup>


  </select>


<!--  status  -->
  <select name="status[]" class="selectpicker" multiple data-width="100%" title="Please select status(s)">


            <optgroup label="Property Status">


                  <option data-content="<span class='label label-primary'>Vacant</span>"  value="Vacant">Vacant</option>
                  <option data-content="<span class='label label-primary'>Owner occupied</span>"  value="Vacant">Owner occupied</option>
                  <option data-content="<span class='label label-primary'>Tenant occupied</span>"  value="Vacant">Tenent occupied</option>

            </optgroup>


  </select>

<!--  min  -->
  <input type="text" class="form-control" name="min" style="width:100%" placeholder="Min size">
  <!--  max  -->
  <input type="text" class="form-control" name="max" style="width:100%" placeholder="Min size">



                    <div class="form-group">
                        <br>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Search</button>
                    </div>
</form>
 <br><br>


 </div>


 <div class="container maintable col-md-12 ">

     <div class="table-responsive  " style="overflow-x:auto;width:100%; ">
                <table class="table table-bordered table-hover ">
                    <thead>
                         <tr class=" w3-blue">
                            <th width="80px" class="hidden-xs">Id</th>
                            <th width="100px">Erf</th>
                            <th width="100px">Area</th>
                            <th width="280px">Address</th>
                            <th width="180px">Title</th>
                            <th width="180px">Type</th>
                            <th width="180px">Status</th>

                         </tr>
                     </thead>
                     <tbody>
                     @foreach ($properties as $property)
                        <tr>
                            <td class="hidden-xs">
                                  {{ $property->id }}
                            </td>
                            <td>
                                {{  $property->erf }}
                            </td>
                            <td>
                                {{  $property->area_id }}
                            </td>
                            <td>
                                {{  $property->address }}
                            </td>
                            <td>
                                {{ $property->title}}
                            </td>
                            <td>
                                 {{ $property->type}}
                            </td>
                            <td>
                                {{  $property->status }}
                            </td>


                        </tr>
                        @endforeach
                     </tbody>
                     </table>
      </div>

     <div class="" style="z-index:-10 !important;float:right;">
          {{$properties->links()}}
     </div>

  </div>

</div>

@endsection
