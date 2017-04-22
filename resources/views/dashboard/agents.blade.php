
@extends('dashboard.dashboard')

<style>
table,tr,td {


  font-size:.9em !important;
table-layout:fixed;

}
</style>
@section('content')


  <!-- Header -->
  <header class="w3-container" style="padding-top:42px">
    <h5><b><i class="fa fa-dashboard"></i> Agents</b></h5><br>
  </header>

 <div class="container maintable col-md-12">

     <div class="table-responsive " style="overflow-x:auto;width:100%; ">
                <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
                    <thead>
                         <tr class=" w3-blue">
                            <th width="80px" class="hidden-xs">Id</th>
                            <th width="180px">Name</th>
                            <th width="180px">Tel</th>
                            <th width="180px">Cell</th>
                            <th width="180px">Email</th>
                            <th width="180px">Photo</th>




                         </tr>
                     </thead>
                     <tbody>
                     @foreach ($agents as $agent)
                        <tr>
                            <td class="hidden-xs">
                                  {{ $agent->id }}
                            </td>
                             <td>
                                {{ $agent->name}}
                            </td>
                             <td>
                                {{ $agent->tel}}
                            </td>
                             <td>
                                {{ $agent->cell}}
                            </td>
                            <td>
                                {{ $agent->email}}
                            </td>

                            <td>
                                 {{ $agent->photo}}
                            </td>


                        </tr>
                        @endforeach
                     </tbody>
                     </table>
      </div>

     <div class="right" style="z-index:-10 !important;float:right;">
         {{$agents->links()}}
     </div>

  </div>

@endsection
