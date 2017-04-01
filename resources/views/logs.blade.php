@extends('layouts.app')
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<style>

html,body,h1,h2,h3,h4,h5,table,th,td
{font-family: "Raleway", sans-serif;
 font-size:small;


}
body {

  background-color: whitesmoke  !important;
}
.searchbar {

    background-color: #F39C12  ;
    padding-top: 25px;
    padding-bottom: 25px;
}

.myleft {

     position:fixed;
    left:100px;
    right:-100px;

}

.area {

     font-size: 0.5em;
     font-weight: bold;
     color: #90B9B9    ;
}
.drop {
 position: relative;
  z-index: -99999;
}

.flexImg {
  width: 400px;
  margin:0 auto;
  text-align: center;
}
</style>






@section('content')





<div id='app' class="container">

  <h2>Logs</h2>







<br>


<div class="container">

<div class="table-responsive " style="background-color:snow;height:600px;width:100%;border:1px solid #ccc;overflow:auto; padding:0px">


                <table class="table table-bordered table-hover ">
                    <thead>
                         <tr>
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
                              {{$activity->causer_id}}
                            </td>
                            <td>
                              {{$activity->properties}}
                            </td>
                        </tr>
                        @endforeach
                     </tbody>
                     </table>
      </div>


</div>
        <button type="button" class="btn btn-default btn-sm pull-right">
          <span class="glyphicon glyphicon-arrow-down"></span> <span class="glyphicon glyphicon-arrow-up"></span> Scroll
        </button>

  <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>

@endsection
