
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
    <h5><b><i class="fa fa-dashboard"></i> Users</b></h5><br>
  </header>

 <div class="container maintable col-md-12">

     <div class="table-responsive " style="overflow-x:auto;width:100%; ">
                <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
                    <thead>
                         <tr class=" w3-blue">
                            <th width="80px" class="hidden-xs">Id</th>
                            <th width="180px">Name</th>
                            <th width="180px">Email</th>
                            <th width="180px">Agent_id</th>
                            <th width="180px">Role_id</th>
                            <th width="180px">Avatar</th>




                         </tr>
                     </thead>
                     <tbody>
                     @foreach ($users as $user)
                        <tr>
                            <td class="hidden-xs">
                                  {{ $user->id }}
                            </td>
                             <td>
                                {{ $user->name}}
                            </td>
                             <td>
                                {{ $user->email}}
                            </td>
                             <td>
                                {{ $user->agent_id}}
                            </td>
                            <td>
                                {{ $user->role_id}}
                            </td>
                            <td>
                                 {{ $user->avatar}}
                            </td>



                        </tr>
                        @endforeach
                     </tbody>
                     </table>
      </div>

     <div class="right" style="z-index:-10 !important;float:right;">
         {{$users->links()}}
     </div>

  </div>

@endsection
