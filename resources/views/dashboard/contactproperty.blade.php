
@extends('dashboard.dashboard')

  <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.2.4.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>

<style>
table,tr,td,p {

  font-size:.98em !important;
  table-layout:fixed;
}
</style>

@section('content')


   <!-- Header -->
  <header class="w3-container" style="padding-top:42px">
    <h5><b><i class="fa fa-dashboard"></i>  Contact</b> </h5><br>
  </header>

 <div class="container maintable col-md-10 ">


    <ul class="w3-ul w3-card-4 w3-white">
    <li>
    <div class="w3-row w3-text-blue">
      <div class="w3-col s8">
        <h3>{{$contact->company}}</h3>
      </div>
    </div>
    <div class="w3-row w3-text-blue">
      <div class="w3-col s12">
        <hr>
      </div>
    </div>

    <div class="w3-row">
      <div class="w3-col s2">
        <p>Contact:</p>
      </div>
      <div class="w3-col s8">
        <p>{{$contact->firstname}} {{$contact->lastname}}</p>
      </div>
    </div>

    <div class="w3-row">
      <div class="w3-col s2">
        <p>Tel:</p>
      </div>
      <div class="w3-col s8">
        <p>{{$contact->tel}}</p>
      </div>
    </div>

    <div class="w3-row">
      <div class="w3-col s2">
        <p>Mobile:</p>
      </div>
      <div class="w3-col s8">
        <p>{{$contact->cell}}</p>
      </div>
    </div>

    <div class="w3-row">
      <div class="w3-col s2">
        <p>Email:</p>
      </div>
      <div class="w3-col s8">
        <p><a href="mailto:{{$contact->email}}">{{$contact->email}}</a></p>
      </div>
    </div>

    <div class="w3-row">
      <div class="w3-col s2">
        <p>Web:</p>
      </div>
      <div class="w3-col s8">
        <p><a href="{{$contact->web}}">{{$contact->web}}</a></p>
      </div>
    </div>


    </li>

</div>

 <div class="container maintable col-md-12 ">
     <br>
     <div class="table-responsive  " style="overflow-x:auto;width:100%; ">
                <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
                    <thead>
                         <tr class=" w3-blue">
                            <th width="80px" class="hidden-xs">Id</th>
                            <th width="100px">Erf</th>
                            <th width="150px">Contact </th>
                            <th width="100px">Area</th>
                            <th width="280px">Address</th>
                            <th width="380px">Title</th>
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
                                <a href="{{ url('/showproperty'.$property->id) }}" > {{  $property->erf }}</a>
                            </td>
                            <td>
                              @foreach ($property->owners as $type)

                                 @if( $type->contact_id == $contact->id )

                                     @if ($type->contact_type_id == 1 )
                                     <p class="w3-text-orange">

                                     [ {{$contacttypes[$type->contact_type_id]->name}} ]
                                      @if ($type->unit_id > 0 ) <i class="w3-text-black">Unit {{$type->unit_id}} </i>@endif

                                     </p>
                                     @endif

                                     @if ($type->contact_type_id == 2 )
                                     <p class="w3-text-green">


                                      [ {{$contacttypes[$type->contact_type_id]->name}} ]
                                      @if ($type->unit_id > 0 ) <i class="w3-text-black">Unit {{$type->unit_id}} </i> @endif
                                      </p>
                                     @endif

                                     @if ($type->contact_type_id == 3 )
                                      <p class="w3-text-green">

                                     [ {{$contacttypes[$type->contact_type_id]->name}} ]
                                       @if ($type->unit_id > 0 ) <i class="w3-text-black">Unit {{$type->unit_id}}</i> @endif
                                     </p>
                                     @endif

                                 @endif



                              @endforeach
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
                                 {{ $ownerships[$property->type]->name}}
                            </td>
                            <td>
                                {{  $stypes[$property->sale_type_id]->name }}
                            </td>


                        </tr>
                        @endforeach
                     </tbody>
                     </table>
      </div>

     <div class="" style="z-index:-10 !important;float:right;">

     </div>

  </div>

</div>

@endsection
