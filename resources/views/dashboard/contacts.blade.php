
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
    <h5><b><i class="fa fa-dashboard"></i> Contacts</b></h5><br>
  </header>

 <div class="container maintable col-md-12">

     <div class="table-responsive " style="overflow-x:auto;width:100%; ">
                <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
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
                                  {{ $owner->id }}
                            </td>
                            <td>
                                 <a href="{{'contactProp'.$owner->id}}" > {{  $owner->company }}</a>

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
