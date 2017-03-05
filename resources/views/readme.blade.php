@extends('layouts.app')

<style>

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



<link href="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.6.3/flexslider.css" rel="stylesheet">


@section('content')





<div id='app' class="container">

  <h2>Things to todo</h2>




<div class="drop" hidden>

  <drop
    :options="options"
    v-model="value"
    :multiple="true"
    :searchable="false"
    deselect-label="Can't remove this value"
     :selected.sync="selected"
        :show-label="false"
  ></drop>

 <pre class="language-json"><code>@{{ selected  }}</code></pre>

</div>


<br>


<div class="container">

<div style="height:600px;width:100%;border:1px solid #ccc;overflow:auto; padding:0px">
  <ul id="sortTrue" v-sortable class="list-group">
<li  class="list-group-item">  <span class="badge">1</span>change tokenmismatch handler in handler to redirect back to login and not home. </li>
<li  class="list-group-item">  <span class="badge">2</span>replace auth in homeController __construct</li>
<li  class="list-group-item">  <span class="badge">3</span>replace auth in VuePropertyController __construct</li>
<li  class="list-group-item">  <span class="badge">4</span>vue.js search pagination</li>
<li  class="list-group-item">  <span class="badge">5</span>search returns only property with units if more than area selected</li>
<li  class="list-group-item">  <span class="badge">6</span>unique erf number?</li>
<li  class="list-group-item">  <span class="badge">6</span>notes and owners display only relevant info ie: unit 0 = </li>
<li  class="list-group-item">  <span class="badge">7</span>cascade deletes for units, notes and owners</li>
<li  class="list-group-item">  <span class="badge">8</span>new VPS and domain name configured</li>
<li  class="list-group-item">  <span class="badge">9</span>configure html->pdf snappy</li>
<li  class="list-group-item">  <span class="badge">10</span>pdf output for property</li>
<li  class="list-group-item">  <span class="badge">11</span>vue-google earth  http://itsolutionstuff.com/post/laravel-5-multiple-markers-in-google-map-using-gmapsjsexample.html</li>
<li  class="list-group-item">  <span class="badge">12</span>create todo app with database</li>
<li  class="list-group-item">  <span class="badge">13</span>unit relation and cascades</li>
<li  class="list-group-item">  <span class="badge">14</span>agents</li>
<li  class="list-group-item">  <span class="badge">15</span>Suburb has many areas</li>
<li  class="list-group-item">  <span class="badge">16</span>user,manager and admin Roles - differect functionality</li>
<li  class="list-group-item">  <span class="badge">17</span>display role in nav</li>
<li  class="list-group-item">  <span class="badge">18</span>image edit .. and manage</li>
<li  class="list-group-item">  <span class="badge">19</span>image delete folder on property delete</li>
<li  class="list-group-item">  <span class="badge">20</span>session timeout not logging out when in vue</li>
<li  class="list-group-item">  <span class="badge">21</span>navbar z-index</li>
<li  class="list-group-item">  <span class="badge">22</span>show/hide detail</li>
<li  class="list-group-item">  <span class="badge">23</span>edit prop - add/select image</li>
<li  class="list-group-item">  <span class="badge">24</span>notes in table overflow</li>
<li  class="list-group-item">  <span class="badge">25</span>reset scrollbar in notes to top</li>
<li  class="list-group-item">  <span class="badge">26</span>github put online add dtabase</li>
<li  class="list-group-item">  <span class="badge">27</span>vue data format moment</li>
<li  class="list-group-item">  <span class="badge">28</span>online path var in properties vue</li>
<li  class="list-group-item">  <span class="badge">29</span>install wkhtmltopdf on server and configure</li>
<li  class="list-group-item">  <span class="badge">30</span>/lib64/libjpeg.so.62  problem - yum reinstall</li>
<li  class="list-group-item">  <span class="badge">31</span>notes not working??? online  == === in v-for</li>
<li  class="list-group-item">  <span class="badge">32</span>format timezone webpack json</li>
<li  class="list-group-item">  <span class="badge">33</span>flexslider</li>
<li  class="list-group-item">  <span class="badge">34</span>install node on server</li>
<li  class="list-group-item">  <span class="badge">35</span>npm install sortable</li>
<li  class="list-group-item">  <span class="badge">36</span>sortable not working on properties</li>
<li  class="list-group-item">  <span class="badge">37</span>Property24 API Soap classes</li>
<li  class="list-group-item">  <span class="badge">38</span>http://www.entegral.net/  SYNC</li>
<li  class="list-group-item">  <span class="badge">39</span>Property24 id and other listing id's</li>
<li  class="list-group-item">  <span class="badge">40</span>geolocate on map - add properties</li>
<li  class="list-group-item">  <span class="badge">41</span>geoogle api key</li>

</ul>
</div>
        <button type="button" class="btn btn-default btn-sm pull-right">
          <span class="glyphicon glyphicon-arrow-down"></span> <span class="glyphicon glyphicon-arrow-up"></span> Scroll
        </button>
<br><br>
<!-- Place somewhere in the <body> of your page -->
<div class="flexslider flexImg" >
  <ul class="slides">
    <li data-thumb="property/1/1.jpg">
      <img src="property/1/1.jpg" />
    </li>
    <li data-thumb="property/2/1.jpg">
      <img src="property/2/1.jpg" />
    </li>
    <li data-thumb="property/4/1.jpg">
      <img src="property/2/1.jpg" />
    </li>
    <li data-thumb="property/3/1.jpg">
      <img src="property/3/1.jpg" />
    </li>

  </ul>
</div>

  <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.2.4.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.6.3/jquery.flexslider.js"></script>
<script>
// Can also be used with $(document).ready()
$(window).load(function() {
  $('.flexslider').flexslider({
    animation: "slide",
    controlNav: "thumbnails"
  });
});
</script>
@endsection
