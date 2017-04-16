
@extends('dashboard.dashboard')

<style>

html,body,table,h1,h2,h3,h4,h5 {

  font-family: "Raleway", sans-serif
font-size:.5em !important;
  font-weight: 100;
}
       p {
        font-size:.8em !important;
        font-weight: 100;
       }

table,tr,td {

  background-color: white !important;
  font-size:.9em !important;


}
.map {
position:relative;
margin-left:-40;
}
</style>
@section('content')


  <!-- Header -->
  <header class="w3-container" style="padding-top:42px">
    <h5><b><i class="fa fa-dashboard"></i> Logs</b></h5><br>
  </header>

 <div class="container maintable col-md-12">

<div class="table-responsive " style="background-color:snow;height:600px;width:100%;border:1px solid #ccc;overflow:auto; padding:0px">


                <table class="table table-bordered table-hover ">
                    <thead class="w3-blue">
                          <tr class=" w3-blue">
                            <th width="100px" class="hidden-xs">#</th>
                            <th width="250px" >Date</th>
                           <th width="200px">Log Name</th>
                            <th width="200px">Action</th>
                            <th width="200px">Id</th>
                            <th width="200px">Model</th>
                            <th width="200px">User</th>

                            <th width="800px">Properties</th>

                         </tr>
                     </thead>
                     <tbody>

                      @foreach ( $activities as $key => $activity )

                        <tr>
                            <td class="hidden-xs">
                              {{ $activity->id }}
                            </td>
                            <td>
                             {{ $activity->created_at->diffForHumans()}}
                            </td>
                            <td>
                             {{$activity->log_name}}
                            </td>
                            <td>
                             {{$activity->description}}
                            </td>
                            <td>
                              {{$activity->subject_id}}
                            </td>
                            <td>
                             {{$activity->subject_type}}
                            </td>
                            <td>
                              {{$users[$activity->causer_id]->name}}
                            </td>
                            <td>
                              {{$activity->properties}}
                            </td>
                        </tr>
                        @endforeach
                     </tbody>
                     </table>
      </div>

        <button type="button" class="btn btn-default btn-sm pull-right">
          <span class="glyphicon glyphicon-arrow-down"></span> <span class="glyphicon glyphicon-arrow-up"></span> Scroll
        </button>
</div>


  <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>


@endsection
