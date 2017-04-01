@extends('layouts.app')

<style>


body {

  background-color: #8BCE92 !important;
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

  <h2>Things to todo</h2>







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
<li  class="list-group-item">  <span class="badge">42</span>Descrip - div scroll</li>
<li  class="list-group-item">  <span class="badge">43</span>Images max 4 for flex</li>
<li  class="list-group-item">  <span class="badge">44</span>Property24 API credentials</li>
<li  class="list-group-item">  <span class="badge">45</span>showproperty rest api</li>
<li  class="list-group-item">  <span class="badge">46</span>showunit rest api</li>
<li  class="list-group-item">  <span class="badge">47</span>auth from Arnold - private prop and prop24 api</li>
<li  class="list-group-item">  <span class="badge">48</span>add user - set role default</li>
<li  class="list-group-item">  <span class="badge">49</span>vue suburb / ptype /stype </li>
<li  class="list-group-item">  <span class="badge">50</span>brochure fix  suburb / ptype /stype - cant use array index</li>
<li  class="list-group-item">  <span class="badge">51</span>dashboard</li>
<li  class="list-group-item">  <span class="badge">52</span>dashboard sidebar partial</li>
<li  class="list-group-item">  <span class="badge">53</span>bootstrap-select multi</li>
<li  class="list-group-item">  <span class="badge">54</span>entegral oms</li>
<li  class="list-group-item">  <span class="badge">55</span>eremove app.js add bootstrap js to manage-prop</li>
<li  class="list-group-item">  <span class="badge">56</span>maps - load thumbnails</li>
<li  class="list-group-item">  <span class="badge">57</span>maps - if no image it is loading the last one</li>
<li  class="list-group-item">  <span class="badge">58</span>centos - caching on server?? </li>
<li  class="list-group-item">  <span class="badge">59</span>install toastr on server</li>
<li  class="list-group-item">  <span class="badge">60</span>install bootstrap-select</li>
<li  class="list-group-item">  <span class="badge">61</span>update to vue 2 - and all the shit that goes with it!!</li>
<li  class="list-group-item">  <span class="badge">62</span>replace vue-resource with axios</li>
<li  class="list-group-item">  <span class="badge">63</span>node npm axios on server</li>
<li  class="list-group-item">  <span class="badge">64</span>gulp --production</li>
<li  class="list-group-item">  <span class="badge">65</span>date order filter - notes and owners</li>
<li  class="list-group-item">  <span class="badge">66</span>https://github.com/freearhey/vue2-filters</li>
<li  class="list-group-item">  <span class="badge">67</span>disable cache on server .htaccess selectpicker</li>
<li  class="list-group-item">  <span class="badge">68</span>jquery selectpicker('reset') in 3 secs</li>
<li  class="list-group-item">  <span class="badge">69</span>location - login dropdown not visible</li>
<li  class="list-group-item">  <span class="badge">70</span>log activity - spatie/laravel-activitylog</li>
<li  class="list-group-item">  <span class="badge">71</span>log activity - sview</li>
<li  class="list-group-item">  <span class="badge">72</span>log activity - spatie/laravel-activitylog</li>
<li  class="list-group-item">  <span class="badge">73</span>redo search with selectpicker</li>
<li  class="list-group-item">  <span class="badge">74</span>add status to search and  unit</li>
<li  class="list-group-item">  <span class="badge">75</span>Forms - disable submit so no double entries</li>
<li  class="list-group-item">  <span class="badge">76</span>Unit - edit</li>
<li  class="list-group-item">  <span class="badge">77</span>sortable fixed in edit item - make practical</li>
<li  class="list-group-item">  <span class="badge">78</span>edit item - add more images</li>
<li  class="list-group-item">  <span class="badge">79</span>Dashboard - showing unit status - using array index nor matching status id !!!!</li>

<li  class="list-group-item">  <span class="badge">80</span> new VPS configure </li>
<li  class="list-group-item">  <span class="badge">81</span> yum install missing libs mbstring sql gd....</li>
<li  class="list-group-item">  <span class="badge">82</span> whktopdf install </li>
<li  class="list-group-item">  <span class="badge">83</span>  selinux enforce 0 </li>
<li  class="list-group-item">  <span class="badge">84</span>  storage user group apache</li>
<li  class="list-group-item">  <span class="badge">85</span>  brochure footer for agents</li>
<li  class="list-group-item">  <span class="badge">86</span>  brochure cover </li>
<li  class="list-group-item">  <span class="badge">87</span> multi units in brochuhre </li>
<li  class="list-group-item">  <span class="badge">88</span>  vps - domain - arecord for dns</li>
<li  class="list-group-item">  <span class="badge">89</span> rest </li>
<li  class="list-group-item">  <span class="badge">90</span> brochure toggle </li>
<li  class="list-group-item">  <span class="badge">90</span> brochure toggle - add user array in units??? accesors mutators in model</li>
<li  class="list-group-item">  <span class="badge">90</span> multiple units in brochure </li>





</ul>
</div>
        <button type="button" class="btn btn-default btn-sm pull-right">
          <span class="glyphicon glyphicon-arrow-down"></span> <span class="glyphicon glyphicon-arrow-up"></span> Scroll
        </button>

  <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>

@endsection
