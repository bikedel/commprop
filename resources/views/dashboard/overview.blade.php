
@extends('dashboard.dashboard')
<style>
html,body,table,h1,h2,h3,h4,h5 {

  font-family: "Raleway", sans-serif
font-size:.7em !important;
  font-weight: 100;
}
       p {
        font-size:.8em !important;
        font-weight: 200;
       }



</style>

@section('content')


  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
  <br>
    <h5><b><i class="fa fa-dashboard"></i> Overview</b></h5>
  </header>

  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-building w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>{{$properties->count()}}</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Properties</h4>
      </div>
    </div>
        <div class="w3-quarter">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-home w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>{{$units->count()}}</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Units</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>{{$units->where('sale_type_id','=','1')->count()}}</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>To Let</h4>
      </div>
    </div>

    <div class="w3-quarter">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-credit-card w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>{{$units->where('sale_type_id','=','2')->count()}}</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>For Sale</h4>
      </div>
    </div>
  </div>

<br>
  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-blue-grey w3-text-white w3-padding">
        <div class="w3-left"><i class="fa  w3-large"></i></div>
        <div class="w3-right">
          <h3>{{$units->where('status_id','=','1')->count()}}</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Vacant</h4>
      </div>
    </div>


    <div class="w3-quarter">
      <div class="w3-container w3-blue-grey w3-text-white w3-padding">
        <div class="w3-left"><i class="fa  w3-large"></i></div>
        <div class="w3-right">
          <h3>{{$units->where('status_id','=','2')->count()}}</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Owner Occupied</h4>
      </div>
    </div>


    <div class="w3-quarter">
      <div class="w3-container w3-blue-grey w3-text-white w3-padding">
        <div class="w3-left"><i class="fa  w3-large"></i></div>
        <div class="w3-right">
          <h3>{{$units->where('status_id','=','3')->count()}}</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Tenant Occupied</h4>
      </div>
    </div>


    <div class="w3-quarter">
      <div class="w3-container w3-blue-grey w3-text-white w3-padding">
        <div class="w3-left"><i class="fa  w3-large"></i></div>
        <div class="w3-right">
          <h3>{{$units->where('status_id','=','4')->count()}}</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Govt/Provincial</h4>
      </div>
    </div>

  </div>



  <div class="w3-container">

      <br>
      <a href="{{ url('/home') }}" class="w3-button w3-dark-grey" role="button">Search Properties  <i class="fa fa-arrow-right"></i></a>
      <br><br>
    <h5>Latest Properties added</h5>
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">


    @for($x = 0; $x < 6; $x++)
          <tr>
          <td>{{ $properties[$x]->created_at->diffForHumans()}}</td>
            <td>{{$properties[$x]->title}}</td>
            @if (($properties[$x]->lat < 18 || $properties[$x]->lat > 1 && abs($properties[$x]->long) < 33 || abs($properties[$x]->long) > 34))
            <td>{{$properties[$x]->address}} <i class="w3-text-red">- Invalid address</i></td>
            @else
            <td>{{$properties[$x]->address}} </td>
            @endif
            <td> <a href="{{ url('/showproperty'.$properties[$x]->id) }}" class="w3-padding"><i class="fa fa-cog fa-fw"></i>  View</a></td>

          </tr>
    @endfor


    </table>
    <!--
     <div class="" style="z-index:-10 !important;float:right;">

     </div>

     -->
    <br>



  </div>

  <div class="w3-container">
  <br>
   <button class="w3-button w3-red" role="button">Alerts  <i class="fa fa-exclamation-triangle"></i></button>
   <br><br>
    <h5>Lease expiring</h5>
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">


    @foreach( $alertunits as $unit)
          <tr>
          <td>Erf: {{ $unit->property->erf}}</td>
            <td>Unit: {{ $unit->id}}</td>
            <td>Lease Start : {{ $unit->lease_start}}</td>
            <td>Lease End : {{ $unit->lease_end}}</td>
             <td> <a href="{{ url('/showproperty'.$unit->property_id) }}" class="w3-padding"><i class="fa fa-cog fa-fw"></i>  View</a></td>

          </tr>
    @endforeach


    </table>

    <br>

  </div>


<!--
  <hr>
  <div class="w3-container">
    <h5>Recent Units added</h5>
    <ul class="w3-ul w3-card-4 w3-white">

    @for($x = 0; $x < 4; $x++)
    @if ( sizeof($properties[$x]->images) > 0 )
      <li class="w3-padding-32">
        <span onclick="this.parentElement.style.display='none'" class="w3-closebtn w3-padding w3-margin-right w3-medium">x</span>

        <img class="img-thumbnail" src="{{ 'property/' . $properties[$x]->id .'/'.  $properties[$x]->images[0]->name }}" class="w3-left  w3-margin-right" style="width:60px;height:60px;">

        <span class="w3-small">Erf: {{$properties[$x]->erf }} Unit: {{$properties[$x]->id}}
           @if ( sizeof($properties[$x]->units) > 0 )

                  Status: {{ $statuses[$properties[$x]->units[0]->status_id-1]->name}}</span>

           @endif

      </li>
      @endif
    @endfor

    </ul>
  </div>
-->



  <hr>

  <div class="w3-container">
    <h5>Brokers</h5>
    <div class="w3-row">
      <div class="w3-col m2 text-center">
        <img class="img-thumbnail" src="agents/jack.png" style="width:96px;height:96px">
      </div>
      <div class="w3-col m10 w3-container">
        <h4>Jack Bass <span class="w3-opacity w3-medium"></span></h4>
        <p>Before joining the property sector, I was involved in the manufacturing, design and distribution of casual furniture and accessories in the USA. After selling my business and moving back to South Africa, I wanted a change in career and decided to give property a try and it?s a choice I?m glad I made! I specialise in industrial property in the Western Cape but I also have experience in retail, commercial and investment properties.</p><br>
      </div>
    </div>

    <div class="w3-row">
      <div class="w3-col m2 text-center">
        <img class="img-thumbnail" src="agents/rob.png" style="width:96px;height:96px">
      </div>
      <div class="w3-col m10 w3-container">
        <h4>Rob Odendaal <span class="w3-opacity w3-medium"></span></h4>
        <p>My career in property began when Tony Galetti asked me to join the company as a broker in 2006. Before becoming a broker, I was a teacher in Cape Town and I also taught in the U.K. for a while. Today, I specialise in industrial and commercial property in the Western Cape. My biggest strength lies in meeting people. I network well and build up relationships and this leads naturally to doing deals on all levels.</p><br>
      </div>
    </div>
  </div>
  <br>
  <div class="w3-container w3-dark-grey w3-padding-32">
    <div class="w3-row">
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-green">Location</h5>
        <p>Claremont Office</p>
        <p>Protea Rd, Claremont</p>
      </div>
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-red">System</h5>
        <p>OS {{$useragent }}</p>
        <p>IP {{$ip}}</p>
      </div>
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-orange">Support</h5>
        <p>User {{ Auth::user()->name }}</p>
        <p>Action Dashboard</p>


      </div>
    </div>

@endsection
