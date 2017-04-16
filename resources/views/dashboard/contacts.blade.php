
@extends('dashboard.dashboard')

<style>
table,tr,td {

  background-color: white !important;
  font-size:.9em !important;


}
</style>
@section('content')


  <!-- Header -->
  <header class="w3-container" style="padding-top:42px">
    <h5><b><i class="fa fa-dashboard"></i> Contacts</b></h5><br>
  </header>

 <div class="container maintable col-md-12">

     <div class="table-responsive " style="overflow-x:auto;width:100%; ">
                <table class="table table-bordered table-hover ">
                    <thead>
                         <tr class=" w3-blue">
                            <th width="80px" class="hidden-xs">Id</th>
                            <th width="180px">Company</th>
                            <th width="180px">FirstName</th>
                            <th width="180px">LastName</th>
                            <th width="180px">Tel</th>
                            <th width="180px">Cell</th>
                            <th width="180px">Email</th>
                            <th width="180px">Web</th>


                         </tr>
                     </thead>
                     <tbody>
                     @foreach ($owners as $owner)
                        <tr>
                            <td class="hidden-xs">
                                  {{ $owner->id }}<a href="{{'contactProp'.$owner->id}}" class="camera"> <span class="glyphicon glyphicon-map-marker"></span></a>
                            </td>
                            <td>
                                {{  $owner->company }}

                            </td>
                             <td>
                                {{ $owner->firstname}}
                            </td>
                             <td>
                                {{ $owner->lastname}}
                            </td>
                             <td>
                                {{ $owner->tel}}
                            </td>
                            <td>
                                {{ $owner->cell}}
                            </td>
                            <td>
                                 {{ $owner->email}}
                            </td>
                             <td>
                                {{ $owner->website}}
                            </td>

                        </tr>
                        @endforeach
                     </tbody>
                     </table>
      </div>

     <div class="right" style="z-index:-10 !important;float:right;">
         {{$owners->links()}}
     </div>

  </div>

@endsection
