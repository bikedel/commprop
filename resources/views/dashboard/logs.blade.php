
@extends('dashboard.dashboard')

<style>

html,body,table,h1,h2,h3,h4,h5 {

  font-family: "Raleway", sans-serif

  font-weight: 100;
}
       p {
        font-size:.8em !important;
        font-weight: 100;
       }

table,tr,td {

  font-size:.9em !important;
table-layout:fixed;

}
.map {
position:relative;
margin-left:-40;
}
</style>
@section('content')

<div class="w3-container" >

  <!-- Header -->
  <header class="w3-container" style="padding-top:42px">
    <h5><b><i class="fa fa-dashboard"></i> Logs</b></h5><br>
  </header>




        <div class="w3-container ">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2></h2>
                </div>
<!--
                 <div class="pull-right">
                    <a href="{{ URL::route('exportUsers') }}" class="btn btn-warning"> Export no contacts</a>
                    <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#">
                      @{{pagination.total}} Records
                    </button>

                </div>
  -->
                <div class="pull-left">
                 @if (  Auth::user()->getRoleName()  == "System")
                    <a href="clearlogs" class="btn btn-success btn-md"> Clear Log</a>
                 @endif
                </div>

            </div>

        </div>

 <div class="w3-container ">
<br>
<div  style="height:615px;width:100%;border:0px solid #ccc;overflow:auto; padding:0px">


                <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
                    <thead>
                          <tr >
                          <!--
                            <th width="120px" class="hidden-xs">Action</th>
                            -->
                            <th width="120px" >When</th>
                            <th width="120px" >Date</th>
                           <th width="100px">Log Name</th>
                            <th width="100px">Action</th>
                            <th width="100px">Id</th>
                            <th width="100px">Model</th>
                            <th width="100px">User</th>

                            <th width="800px">Properties</th>

                         </tr>
                     </thead>
                     <tbody>

                      @foreach ( $activities as $key => $activity )

                        <tr>
                        <!--
                            <td class="hidden-xs">

                              <button class="btn btn-primary btn-xs" @click.prevent="editItem(item)"> Edit</button>
                              <button class="btn btn-danger btn-xs" @click.prevent="deleteItem(item)">Delete</button>

                            </td>
                          -->
                          <?php date_default_timezone_set('UTC');
date_default_timezone_set('Africa/Johannesburg');?>
                            <td>
                             {{ $activity->created_at->diffForHumans()}}
                            </td>
                            <td>
                             {{ date('D m Y  H:i', strtotime($activity->created_at ))}}
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
                              @if (array_key_exists($activity->causer_id,$users->toArray()))
                              {{$users[$activity->causer_id]->name}}
                              @else
                                {{$activity->causer_id}}
                              @endif
                            </td>
                            <td>
                              {{$activity->properties}}
                            </td>
                        </tr>
                        @endforeach
                     </tbody>
                     </table>
      </div>


      <div class="" style="z-index:-10 !important;float:right;">
          {{$activities->links()}}
     </div>
</div>
</div>

  <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.2.4.min.js"></script>
  <script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>


@endsection
