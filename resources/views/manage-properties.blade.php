
@extends('layouts.app')


@section('content')




     <!-- toastr -->
     <link href="https://cdn.jsdelivr.net/toastr/2.1.3/toastr.min.css" rel="stylesheet">


    <link href="css/bootstrap-select.css" rel="stylesheet">



<style type="text/css">

/*
   tr:nth-child(even){background-color: #f2f2f2}
   tr:nth-child(odd){background-color: #ECF2F9}
*/
.fred{

    background-color: lightblue;
    color:white;
}





input:-webkit-autofill {
    -webkit-box-shadow: 0 0 0px 1000px #ffffff inset!important;
}

    table
    {
      table-layout:fixed;
    }

    th {

        color:white;
        background-color: #6594B4  !important;
        border-width: 1px;
        opacity: 0.8;
    }

    table td  {
        padding: 5px;
        text-overflow: ellipsis;
        max-width:1500px;
        overflow:hidden;
        white-space:nowrap;
    }

    .newAgent{
          border-color: black !important;
          color:red;
    }

    .table-bordered td, .table-bordered th{
        border-color: black !important;
    }

    .slategrey-background {
      background-color: #D9E3EE;
    }

.modal-header {
    background-color: #008DB7;
}

.modal-body {
   background-color: WhiteSmoke ;
}

.modal-title {

color:white;
}

#custom-search-input {
        margin:0;
        margin-top: 10px;
        padding: 0;
    }

    #custom-search-input .search-query {
        padding-right: 3px;
        padding-right: 4px \9;
        padding-left: 3px;
        padding-left: 4px \9;
        /* IE7-8 doesn't have border-radius, so don't indent the padding */

        margin-bottom: 0;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
    }

    #custom-search-input button {
        border: 30;
        background: #008DB7;
        /** belows styles are working good */
        padding: 6px 8px;
        margin-top: 1px;
        position: relative;
        left: 2px;
        /* IE7-8 doesn't have border-radius, so don't indent the padding */
        margin-bottom: 0;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        color: white;
    }

    .search-query:focus + button {
        z-index: 8;
    }

pre {
    display: block;
    height:200px;

                font-family: 'Lato';
    white-space: pre;
    margin: 1em 0;
}

[v-cloak] { display: none; }

.searchbar {
    top:-22px;
    padding:0px;
    background-color: #6594B4  ;
    padding-top: 45px;
    padding-bottom: 45px;
    z-index:auto !important;
}



.total {
    position:relative;
    float:left;
    margin-right:40px;
    left:20px;
}

.newprop {

    position:relative;
    float:right;
    margin-left:20px;
}

.hide {
     display: none;
}


.items{


     padding:20px;


}
div.myprop {
  transition: background-color 0.5s ease;

}
div.myprop:hover {
  background-color: #F6F9FC;
}

red {

    color:red;
    font-weight:bold;
}
blue {

    color:black;
    font-weight:bold;
}
small {

    color:#ccc  !important;
}
.myBtnColor,
.myBtnColor a {
  color: #fff !important;
  background-color: #F1C40F !important;
  border-color: #F1C40F !important;
}
.myBtnColor:active,
.myBtnColor.active,
.myBtnColor:focus,
.myBtnColor.focus,
.myBtnColor:hover,
.myBtnColor a:hover {

  background-color: #D4AC0D !important;
  border-color: #ccc !important;
}

.descrip {
   position:relative;
   padding-left:20px;
}


.caption {
    display: block;
    margin:0 auto;
    background: white;
    padding-left:10px;
    padding-bottom:5px;
    color: black;
    opacity: 0.4;
    position: relative;
    height:25px;
    left:0;
    bottom:0;
    top:-25px;
    z-index:1;
}

.captiontext {
    position: relative;
    background-color: white;
    color:black;
    float:left !important;
    opacity:1;
    z-index:40;
    font-weight: bold

}

.camera {
     position: relative;
    float:right;
    left:-20px;
    top:2px;
}

.map {
     position: relative;
    float:left;
    left:0px;
    top:2px;
    padding:0px 5px 0px 0px;
}
#itemdetails table tbody tr td {
    border: none  !important;
       border-top: none !important;
    border-left: none !important;
    border-bottom: none !important;
    background-color:white;
}

.pagination>.active>a, .pagination>.active>span, .pagination>.active>a:hover, .pagination>.active>span:hover, .pagination>.active>a:focus, .pagination>.active>span:focus {
    z-index: -100;

}

.thetoggle {
line-height: 1.8;
    opacity:0.1;
     outline: none;
     color:white;

}
.spacer {

    padding: 0px 10px 0px 10px;
}
</style>


 <div  v-cloak id="manage-properties">



<div class=" searchbar col-md-12 ">

<div class=" col-md-12  ">
<div class="row ">
<form id='search' class="form-inline form-group col-md-offset-1" method="POST" enctype="multipart/form-data" v-on:submit.prevent="searchVueItems">

<br>
                        <input id='s_erf' type="text"  class="form-control" style="width:100px" placeholder="Erf" v-model="s_erf" />

<!--
                        <select  id ='s_area'  name='s_area' class="form-control "   v-model="s_area"   >
                           <option value="0"  selected >All areas</option>
                               <option v-for="area in areas" v-bind:value="area.id"  >
                                    @{{ area.name }}
                               </option>
                        </select>
-->

                        <!--  areas  -->
                          <select id="picker" name="sel[]" class="selectpicker form-control" multiple  data-width="150px" data-live-search="true" title="All suburbs"  v-model="s_area" >
                                       <optgroup v-for="area in areas" :label="area.name">
                                          <option   v-for="suburb in area.suburbs"   v-bind:value="suburb.id" > @{{ suburb.name }}</option>
                                        </optgroup>
                          </select>


                        <select  id ='s_ptype'  name ='s_ptype[]' class="form-control selectpicker" multiple  data-width="150px" title="All properties" v-model="s_ptype">
                               <option v-for="ptype in ptypes" v-bind:value="ptype.id"  >
                                    @{{ ptype.name }}
                               </option>
                        </select>

                        <select  id ='s_stype' name ='s_stype[]' class="form-control selectpicker"  multiple  data-width="100px" title="All types" v-model="s_stype" >
                               <option v-for="stype in stypes" v-bind:value="stype.id"  >
                                    @{{ stype.name }}
                               </option>
                        </select>

                        <select  id ='s_status' name ='s_status[]' class="form-control selectpicker"  multiple  data-width="150px" title="All status" v-model="s_status" >
                               <option v-for="status in statuses" v-bind:value="status.id"  >
                                    @{{ status.name }}
                               </option>
                        </select>


                        <input id='s_minsize' type="text" name="s_minsize" class="form-control" style="width:100px" placeholder="min size" v-model="s_minsize" />

                        <input id='s_maxsize' type="text" name="s_maxsize" class="form-control" style="width:100px" placeholder="max size" v-model="s_maxsize"  />

                          <label>
                            {!! Form::submit('Search',array('class'=>'btn btn-primary')) !!}

                          </label>
                        <button class="btn btn-success " @click.prevent="resetSearch()">Reset</button><p v-if="searching == true" style="color:white;"><i class="fa fa-refresh fa-spin fa-2x fa-fw" aria-hidden="true"></i>Searching...</p>

   </form>
</div>
</div>
</div>

 <div class=" col-md-10 col-md-offset-1" >
        <!-- Pagination -->
<div class="row ">



        <!-- Pagination -->
        <nav style="z-index:-100;">
            <ul class="pagination .pagination-sm">
            <li> <button class="btn btn-default newprop" @click.prevent="showBrochures">Print Brochure</button> </li>
            <li> <button class="btn btn-success newprop" @click.prevent="createForms">New Property</button> </li>

            <li><button type="button" class="btn btn-default total" disabled >@{{pagination.total}} records</button></li>
                <li v-if="pagination.current_page > 1">
                    <a href="#" aria-label="Previous"
                       @click.prevent="changePage(pagination.current_page - 1)">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>
                <li v-for="page in pagesNumber"
                    v-bind:class="[ page == isActived ? 'active' : '']">
                    <a href="#"
                       @click.prevent="changePage(page)">@{{ page }}</a>
                </li>
                <li v-if="pagination.current_page < pagination.last_page">
                    <a href="#" aria-label="Next"
                       @click.prevent="changePage(pagination.current_page + 1)">
                        <span aria-hidden="true">»</span>
                    </a>
                </li>
            </ul>
        </nav>





<div class="items" v-for="item in items" :key="item.id">



    <h3>@{{ item.title }}</h3>
 <!--   <p><a v-bind:href="'gotoProperty'+item.id" class="map"> <span class="glyphicon glyphicon-map-marker"></span></a>@{{ suburbName(item.area_id) }}</p>  -->

<div v-if="(item.lat < 18 || item.lat > 1 && Math.abs(item.long) < 33 || Math.abs(item.long) > 34)">
   <p><a v-bind:href="'gotoProperty'+item.id" class="map"> <span class="glyphicon glyphicon-map-marker"></span></a>@{{ item.address }}<red>- Invalid address</red></p>
</div>
<div v-else>
    <p><a v-bind:href="'gotoProperty'+item.id" class="map"> <span class="glyphicon glyphicon-map-marker"></span></a>@{{ item.address }}</p>
</div>



    <div class=" row border myprop" >

             <div class='prop_img col-sm-4' >

                   <div v-if ="item.images[0] && item.image_id == 0">
                     <img :src="offlinePath+'/commprop/public/property/'+item.id+'/'+ item.images[0].name  " width="98%"  >
                     <div class='caption'>
                     <p class="captiontext"> @{{ item.images[0].caption }}</p>
                        <a v-bind:href="'showproperty'+item.id" class="camera">@{{ item.images.length }} <span class="glyphicon glyphicon-camera"></span></a>
                     </div>
                    </div>

                   <div v-else-if="item.images.length > 0 && item.image_id > 0">

                     <div v-for="image in item.images" v-if="image.id == item.image_id">
                         <img :src="offlinePath+'/commprop/public/property/'+item.id+'/'+ image.name " width="98%"  >
                     </div>


                     <div class='caption'>
                     <p class="captiontext"></p>
                        <a v-bind:href="'showproperty'+item.id" class="camera">@{{ item.images.length }} <span class="glyphicon glyphicon-camera"></span> </a>
                     </div>
                    </div>

                   <div v-else>
                     <img :src="offlinePath+'/commprop/public/img/building_small.jpg'" width="98%"  >
                     <div class='caption'>
                     <p class="captiontext">This property has no Image</p>
                        <a v-bind:href="'showproperty'+item.id" class="camera"> <span class="glyphicon glyphicon-camera"></span> </a>
                     </div>
                    </div>

             </div>

            <div class='descrip col-sm-8'>
            <div style="height:120px;width:100%;border:0px solid #ccc;overflow:auto; padding:0px">

            <p>Erf: <b>@{{ item.erf }}  </b>   <i >  <a class="spacer" v-bind:href="'showproperty'+item.id"><span class="glyphicon glyphicon-info-sign"></span></a></i></p>
                @{{ item.description }}
            </div>
            <div><hr><p>This property has @{{ item.units.length }} unit(s).</p>
            </div>
            </div>

     </div>

     <div class = "row actions">

         <!--  <button class="btn myBtnColor btn-xs" v-on:click="seen = !seen">Details</button>  -->
            <button class="btn btn-default btn-xs" v-if="seen" v-on:click="seen = !seen">Hide Details</button>
            <button class="btn btn-default btn-xs" v-else="!seen" v-on:click="seen = !seen">Show Details</button>

           @if ( Auth::user()->getRoleName()  == "Admin")

               <button class="btn btn-primary btn-xs" @click.prevent="editItem(item)">Edit</button>
               <button class="btn btn-success btn-xs " @click.prevent="addUnit(item)">Add Unit</button>
               <button class="btn btn-danger btn-xs" @click.prevent="deleteItem(item)">Delete</button>

           @endif
           <!-- editnote and contacts - second param is 0 for main property -->
           <button id="notes_button" class="btn btn-warning btn-xs" @click.prevent="editNote(item,0)">Notes</button>
           <button class="btn btn-info btn-xs" @click.prevent="editOwner(item,0)">Contacts</button>

     </div>


        <div id="myDIV"  >

             <div id="itemdetails" class=" table-responsive table-no-bordered"  style="overflow-x:auto;">
                <table  class="table  ">

                     <tbody>
                     <tr>
                         <td v-if="seen" width="150">Type   </td>
                         <td v-if="seen" width="200">@{{ typeName(item.type) }}</td>
                     </tr>
                     <tr>
                         <td v-if="seen" >Status   </td>
                         <td v-if="seen">@{{ saleTypeName(item.sale_type_id) }}</td>
                     </tr>
                     <tr>
                         <td v-if="seen" >Grade   </td>
                         <td v-if="seen">@{{ gradeName(item.grade_id) }}</td>
                     </tr>
                     <tr>
                         <td v-if="seen" >Erf Size   </td>
                         <td v-if="seen">@{{ item.erf_size }} m<sup>2</sup></td>
                     </tr>
                     <tr>
                         <td v-if="seen" width="100">Building Size   </td>
                         <td v-if="seen">@{{ item.building_size }} m<sup>2</sup></td>
                     </tr>
                     <tr>
                         <td v-if="seen" width="100">Open Parking   </td>
                         <td v-if="seen">@{{ item.open_parking_bays }}</td>
                     </tr>
                      <tr>
                         <td v-if="seen" width="100">Covered Parking   </td>
                         <td v-if="seen">@{{ item.covered_parking_bays }}</td>
                     </tr>
                     </tbody>
                     </table>
            </div>

        </div>




        <div class='units'>
             <br>

             <div class="table-responsive  " style="overflow-x:auto; ">
                <table class="table table-hover ">
                    <thead>
                         <tr>
                            <th width="90px" class="hidden-xs">Unit ID</th>
                            <th width="110px">Section</th>
                            <th width="140px">Status</th>
                            <th width="220px">Type</th>
                            <th width="100px">Size</th>
                            <th width="140px">Price</th>
                            <th width="220px">Actions</th>

                         </tr>
                     </thead>
                     <tbody>
                        <tr v-for="unit in item.units">
                            <td class="hidden-xs">
                               @{{ unit.id }}
                            </td>
                            <td>
                                @{{  unit.section  }}

                            </td>

                            <td>
                                @{{  statusName( unit.status_id ) }}

                            </td>
                            <td>
                                @{{  propertyTypeName( unit.property_type_id ) }}   @{{  saleTypeName( unit.sale_type_id ) }}

                            </td>
                            <td>
                                @{{ unit.size}}   m<sup>2</sup>
                            </td>
                            <td>
                                 @{{ unit.price | currency('R ')}}
                            </td>
                            <td class="actions">

                               <button title="Brochure On" v-if="inArray(user,unit.brochure_users)" class="btn btn-success btn-xs pull right"   @click.prevent="setBrochure(item,unit)">B<span class="glyphicon "></span>  </button>
                               <button title="Brochure Off" v-else class="btn btn-default btn-xs pull right"   @click.prevent="setBrochure(item,unit)">B<span class="glyphicon "></span>  </button>


                               <button title="Notes" class="btn btn-warning btn-xs pull right" @click.prevent="editNote(item,unit)"><span class="glyphicon glyphicon-list-alt"></span> </button>
                               <button title="Contacts" class="btn btn-info btn-xs pull right" @click.prevent="editOwner(item,unit)"> <span class="glyphicon glyphicon-user"></span> </button>
                               @if ( Auth::user()->getRoleName()  == "Admin")
                                   <button title="Edit" class="btn btn-primary btn-xs" @click.prevent="editUnit(item,unit)"><span class="glyphicon glyphicon-pencil"></span> </button>
                                   <button title="Delete" class="btn btn-danger btn-xs pull right" @click.prevent="deleteUnit(unit)"><span class="glyphicon glyphicon-trash"></span> </button>
                               @endif

                               <!--  <a v-bind:href="'showunit'+unit.id" class="btn btn-default btn-xs pull right" role="button">Details</a>  -->
                            </td>
                        </tr>
                     </tbody>
                     </table>
            </div>


         </div>

         <hr class="style-one">
         </div>

        <!-- Pagination -->
        <nav>
            <ul class="pagination .pagination-sm">
            <li><button type="button" class="btn btn-default total" disabled >@{{pagination.total}} records</button></li>
                <li v-if="pagination.current_page > 1">
                    <a href="#" aria-label="Previous"
                       @click.prevent="changePage(pagination.current_page - 1)">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>
                <li v-for="page in pagesNumber"
                    v-bind:class="[ page == isActived ? 'active' : '']">
                    <a href="#"
                       @click.prevent="changePage(page)">@{{ page }}</a>
                </li>
                <li v-if="pagination.current_page < pagination.last_page">
                    <a href="#" aria-label="Next"
                       @click.prevent="changePage(pagination.current_page + 1)">
                        <span aria-hidden="true">»</span>
                    </a>
                </li>
            </ul>
        </nav>

</div>
 <!-- <pre>@{{ $data | json }}</pre>   -->

        <!-- Create Item Modal -->

        <div class="modal " id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form id="createProp" method="POST" enctype="multipart/form-data" v-on:submit.prevent="createItem">
              <div class="modal-header">
                <button type="button" id="create-item-modal-header-button" class="close" data-dismiss="modal"  aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myCreateModalLabel">Create Property</h4>
              </div>
              <div class="modal-body">




                    @if ( Session::has('flash_message') )
                      <div class="alert {{ Session::get('flash_type') }} ">
                        <button type="button" class="form-group btn close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <p>{{ Session::get('flash_message') }}</p>
                      </div>
                    @endif

                    <div class="form-group">
                       <span v-if="formErrors['test']" class="error text-danger">@{{ formErrors['test'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Erf Number:</label>
                        <input type="text" name="erf" class="form-control" v-model="newItem.erf" />
                        <span v-if="formErrors['erf']" class="error text-danger">@{{ formErrors['erf'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Title:</label>
                        <input type="text" name="title" class="form-control" v-model="newItem.title" />
                        <span v-if="formErrors['title']" class="error text-danger">@{{ formErrors['title'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Description:</label>
                        <textarea type="text" name="description" rows="5" class="form-control" v-model="newItem.description" ></textarea>
                        <span v-if="formErrors['description']" class="error text-danger">@{{ formErrors['description'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Address:</label>
                        <textarea type="text" name="address" rows="2" class="form-control" v-model="newItem.address" ></textarea>
                        <span v-if="formErrors['address']" class="error text-danger">@{{ formErrors['address'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Street:</label>
                        <input type="text" name="street" class="form-control" v-model="newItem.street" />
                        <span v-if="formErrors['street']" class="error text-danger">@{{ formErrors['street'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Suburb:</label>
                        <select  id ='area_id' name='area_id' class="form-control selectpicker" data-live-search="true" title='Select area...' data-width="100%" v-model="newItem.area_id"   >
                                    <optgroup v-for="area in areas" :label="area.name">
                                          <option   v-for="suburb in area.suburbs"   v-bind:value="suburb.id" > @{{ suburb.name }}</option>
                                    </optgroup>
                        </select>
                        <span v-if="formErrors['area_id']" class="error text-danger">@{{ formErrors['area_id'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Ownership Type:</label>
                       <select  id ='ownership' name ='ownership' class="form-control selectpicker"   title='Select ownership type...' data-width="100%"  v-model="newItem.ownership" >
                               <option  v-bind:value="0"  > Freehold </option>
                                <option  v-bind:value="1"  > Sectional Title </option>
                        </select>
                        <span v-if="formErrors['ownership']" class="error text-danger">@{{ formErrors['ownership'][0] }}</span>
                    </div>
<!--
                    <div class="form-group">
                        <label for="Firstname">Status:</label>
                       <select  id ='status' name ='status' class="form-control selectpicker"   title='Select status...' data-width="100%"  v-model="newItem.status" >
                               <option v-for="status in statuses" v-bind:value="status.id"  >
                                    @{{ status.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['status']" class="error text-danger">@{{ formErrors['status'][0] }}</span>
                    </div>

-->
                    <div class="form-group">
                        <label for="Firstname">Status:</label>
                        <select  id='sale_type_id' name='sale_type_id' class="form-control selectpicker"  title='Select sale type...' v-model="newItem.sale_type_id"  style="width: 100%;"  >

                               <option v-for="stype in stypes" :value="stype.id"  >
                                    @{{ stype.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['sale_type_id']" class="error text-danger">@{{ formErrors['sale_type_id'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Grade:</label>
                        <select  id='grade_id' name='grade_id' class="form-control selectpicker"  title='Select grade...' v-model="newItem.grade_id"  style="width: 100%;"  >

                               <option v-for="grade in grades" :value="grade.id"  >
                                    @{{ grade.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['grade_id']" class="error text-danger">@{{ formErrors['grade_id'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Erf Size:</label>
                        <input type="text" name="erf_size" rows="2" class="form-control" v-model="newItem.erf_size" />
                        <span v-if="formErrors['erf_size']" class="error text-danger">@{{ formErrors['erf_size'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Building Size:</label>
                        <input type="text" name="building_size" class="form-control" v-model="newItem.building_size" />
                        <span v-if="formErrors['building_size']" class="error text-danger">@{{ formErrors['building_size'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Open Parking:</label>
                        <input type="text" name="open_parking_bays" class="form-control" v-model="newItem.open_parking_bays" />
                        <span v-if="formErrors['open_parking_bays']" class="error text-danger">@{{ formErrors['open_parking_bays'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Covered Parking:</label>
                        <input type="text" name="covered_parking_bays" class="form-control" v-model="newItem.covered_parking_bays" />
                        <span v-if="formErrors['covered_parking_bays']" class="error text-danger">@{{ formErrors['covered_parking_bays'][0] }}</span>
                    </div>

                    <div class="form-group">
                    <label for="Firstname">Image(s):</label>

                        <input type="file" id="image" class="btn btn-default " name="image[]" multiple  style="width: 100%;"  @change="getImage"/>

                        <span v-if="formErrors['image']" class="error text-danger">@{{ formErrors['image'][0] }}</span>
                    </div>


              </div>
            <div class="modal-footer">
                  <!--  <button id="print" type="submit" class="btn btn-success">Print</button> -->
                 <button id="create-item-submit" type="submit" class="btn btn-success">Submit</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
            </div>
          </div>
        </div>

        <!-- Edit Item Modal -->
        <div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form id="editProp" method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id)">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Property  - <small>Erf @{{fillItem.erf}}</small></h4>
              </div>
              <div class="modal-body">



                    <div class="form-group">
                       <span v-if="formErrorsUpdate['test']" class="error text-danger">@{{ formErrorsUpdate['test'][0] }}</span>
                    </div>

                    <div class="form-group" hidden>
                        <label for="Surname">Id:</label>
                        <input type="text" name="id" class="form-control" v-model="fillItem.id" />
                        <span v-if="formErrorsUpdate['id']" class="error text-danger">@{{ formErrorsUpdate['id'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Erf Number:</label>
                        <input type="text" id="erf" name="erf" class="form-control" v-model="fillItem.erf" />
                        <span v-if="formErrorsUpdate['erf']" class="error text-danger">@{{ formErrorsUpdate['erf'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Title:</label>
                        <input type="text" name="title" class="form-control" v-model="fillItem.title" />
                        <span v-if="formErrorsUpdate['title']" class="error text-danger">@{{ formErrorsUpdate['title'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Description:</label>
                        <textarea type="text" name="description" rows="5" class="form-control" v-model="fillItem.description"  ></textarea>
                        <span v-if="formErrorsUpdate['description']" class="error text-danger">@{{ formErrorsUpdate['description'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Address:</label>
                        <textarea type="text" name="address" rows="2" class="form-control" v-model="fillItem.address" ></textarea>
                        <span v-if="formErrorsUpdate['address']" class="error text-danger">@{{ formErrorsUpdate['address'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Street:</label>
                        <input type="text" id="street" name="erf" class="form-control" v-model="fillItem.street" />
                        <span v-if="formErrorsUpdate['street']" class="error text-danger">@{{ formErrorsUpdate['street'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Suburb:</label>
                       <select  id ='area_id' name='area_id' class="form-control selectpicker"  data-live-search="true"  v-model="fillItem.area_id"  style="width: 100%;"  >
                                       <optgroup v-for="area in areas" :label="area.name">
                                          <option   v-for="suburb in area.suburbs"     v-bind:value="suburb.id" > @{{ suburb.name }}</option>
                                        </optgroup>
                        </select>
                        <span v-if="formErrorsUpdate['area_id']" class="error text-danger">@{{ formErrorsUpdate['area_id'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Ownership Type:</label>
                       <select  id ='ownership' name ='ownership' class="form-control "   data-width="100%"  v-model="fillItem.ownership" >
                               <option  v-bind:value='0'  > Freehold </option>
                                <option  v-bind:value='1'  > Sectional Title </option>
                        </select>
                        <span v-if="formErrorsUpdate['ownership']" class="error text-danger">@{{ formErrorsUpdate['ownership'][0] }}</span>
                    </div>
<!--
                    <div class="form-group">
                        <label for="Firstname">Status:</label>
                       <select  id ='status' name ='status' class="form-control "   data-width="100%"  v-model="fillItem.status" >
                               <option v-for="status in statuses" v-bind:value="status.id"  >
                                    @{{ status.name }}
                               </option>
                        </select>
                        <span v-if="formErrorsUpdate['status']" class="error text-danger">@{{ formErrorsUpdate['status'][0] }}</span>
                    </div>
-->

                    <div class="form-group">
                        <label for="Firstname">Status:</label>
                        <select  id='sale_type_id' name='sale_type_id' class="form-control "   v-model="fillItem.sale_type_id"   style="width: 100%;"  >

                               <option v-for="stype in stypes" :value="stype.id"  >
                                    @{{ stype.name }}
                               </option>
                        </select>
                        <span v-if="formErrorsUpdate['sale_type_id']" class="error text-danger">@{{ formErrorsUpdate['sale_type_id'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Grade:</label>
                        <select  id='grade_id' name='grade_id' class="form-control "   v-model="fillItem.grade_id"  style="width: 100%;"  >

                               <option v-for="grade in grades" :value="grade.id"  >
                                    @{{ grade.name }}
                               </option>
                        </select>
                        <span v-if="formErrorsUpdate['grade_id']" class="error text-danger">@{{ formErrorsUpdate['grade_id'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Erf Size:</label>
                        <input type="text" name="erf_size" rows="2" class="form-control" v-model="fillItem.erf_size" />
                        <span v-if="formErrorsUpdate['erf_size']" class="error text-danger">@{{ formErrorsUpdate['erf_size'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Building Size:</label>
                        <input type="text" name="building_size" class="form-control" v-model="fillItem.building_size" />
                        <span v-if="formErrorsUpdate['building_size']" class="error text-danger">@{{ formErrorsUpdate['building_size'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Open Parking:</label>
                        <input type="text" name="open_parking_bays" class="form-control" v-model="fillItem.open_parking_bays" />
                        <span v-if="formErrorsUpdate['open_parking_bays']" class="error text-danger">@{{ formErrorsUpdate['open_parking_bays'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Covered Parking:</label>
                        <input type="text" name="covered_parking_bays" class="form-control" v-model="fillItem.covered_parking_bays" />
                        <span v-if="formErrorsUpdate['covered_parking_bays']" class="error text-danger">@{{ formErrorsUpdate['covered_parking_bays'][0] }}</span>
                    </div>

                    <div class="form-group">
                    <label for="Firstname">Add Image(s):</label>

                        <input type="file" id="addimage" class="btn btn-default " name="addimage[]" multiple  style="width: 100%;"  @change="getAddImage"/>

                        <span v-if="formErrorsUpdate['image']" class="error text-danger">@{{ formErrorsUpdate['image'][0] }}</span>
                    </div>


                    <div class="form-group">
                    <label for="Firstname">Existing Image(s):</label>
                    <div style="height:200px;width:100%;border:1px solid #ccc;overflow:auto; padding:0px">
                            <ul  id="imageOrder"  name="theimageorder" class="list-group"  v-sortable  >
                                 <li :id="item.id" class="list-group-item "  v-for="(item, key)  in orderBy(fillItem.image,'order') " >   @{{ item.id }} <img :src="offlinePath+'/commprop/public/property/'+fillItem.id+'/'+ item.name  " width="40px" /> <button  title="item.id "  class="btn btn-danger btn-xs pull right"   @click.prevent="deleteImage(item,key)"><span class="glyphicon glyphicon-remove"></span> Delete </button></li>


                                 <li class="list-group-item "  v-if="fillItem.image.length <= 0 " >   No images uploaded </li>
                            </ul>
                    </div>
                    </div>


              </div>
            <div class="modal-footer">
                  <!--  <button id="print" type="submit" class="btn btn-success">Print</button> -->
                 <button id="edit-item-submit" type="submit" class="btn btn-success">Submit</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
            </div>
          </div>
        </div>


        <div class="modal " id="create-unit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form id="createUnit" method="POST" enctype="multipart/form-data" v-on:submit.prevent="createUnit">
              <div class="modal-header">
                <button type="button" id="create-item-modal-header-button" class="close" data-dismiss="modal"  aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myCreateModalLabel">Add Unit - <small>Erf @{{newUnit.erf}}</small></h4>
              </div>
              <div class="modal-body">


                    @if ( Session::has('flash_message') )
                      <div class="alert {{ Session::get('flash_type') }} ">
                        <button type="button" class="form-group btn close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <p>{{ Session::get('flash_message') }}</p>
                      </div>
                    @endif

                    <div class="form-group">
                       <span v-if="formErrors['test']" class="error text-danger">@{{ formErrors['test'][0] }}</span>
                    </div>

                    <div class="form-group" hidden>
                        <label for="Surname">Id:</label>
                        <input type="text" name="id" class="form-control" v-model="newItem.id" readonly/>
                        <span v-if="formErrors['id']" class="error text-danger">@{{ formErrors['id'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Unit/Section:</label>
                        <input type="text" name="section" class="form-control" v-model="newUnit.section" />
                        <span v-if="formErrors['section']" class="error text-danger">@{{ formErrors['section'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Property Type:</label>

                        <select  id='property_type_id' name='property_type_id' class="form-control "  v-model="newUnit.property_type_id"  style="width: 100%;"  >
                           <option value="0" disabled  hidden>Please select property type...</option>
                               <option v-for="ptype in ptypes" :value="ptype.id"  >
                                    @{{ ptype.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['property_type_id']" class="error text-danger">@{{ formErrors['property_type_id'][0] }}</span>
                    </div>


                    <div class="form-group">
                        <label for="Firstname">Sale Type:</label>

                        <select  id='sale_type_id' name='sale_type_id' class="form-control "  v-model="newUnit.sale_type_id"  style="width: 100%;"  >
                           <option value="0" disabled  hidden>Please select sale type...</option>
                               <option v-for="stype in stypes" :value="stype.id"  >
                                    @{{ stype.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['sale_type_id']" class="error text-danger">@{{ formErrors['sale_type_id'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Status:</label>

                        <select  id='status_id' name='status_id' class="form-control "  v-model="newUnit.status_id"  style="width: 100%;"  >
                           <option value="0" disabled  hidden>Please select status...</option>
                               <option v-for="status in statuses" :value="status.id"  >
                                    @{{ status.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['status_id']" class="error text-danger">@{{ formErrors['status_id'][0] }}</span>
                    </div>


                    <div class="form-group" >
                        <label for="Surname">Size:</label>
                        <input type="text" name="size" class="form-control" v-model="newUnit.size" />
                        <span v-if="formErrors['size']" class="error text-danger">@{{ formErrors['size'][0] }}</span>
                    </div>


                    <div class="form-group" >
                        <label for="Surname">Price:</label>
                        <input type="text" name="price" class="form-control" v-model="newUnit.price" />
                        <span v-if="formErrors['price']" class="error text-danger">@{{ formErrors['price'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Gross Rental:</label>
                        <input type="text" name="gross_rental" class="form-control" v-model="newUnit.gross_rental" />
                        <span v-if="formErrors['gross_rental']" class="error text-danger">@{{ formErrors['gross_rental'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Net Rental:</label>
                        <input type="text" name="net_rental" class="form-control" v-model="newUnit.net_rental" />
                        <span v-if="formErrors['net_rental']" class="error text-danger">@{{ formErrors['net_rental'][0] }}</span>
                    </div>

                   <div class="form-group" >
                        <label for="Surname">Ops Costs:</label>
                        <input type="text" name="ops_costs" class="form-control" v-model="newUnit.ops_costs" />
                        <span v-if="formErrors['ops_costs']" class="error text-danger">@{{ formErrors['ops_costs'][0] }}</span>
                    </div>

                   <div class="form-group" >
                        <label for="Surname">Rates:</label>
                        <input type="text" name="rates" class="form-control" v-model="newUnit.rates" />
                        <span v-if="formErrors['rates']" class="error text-danger">@{{ formErrors['rates'][0] }}</span>
                    </div>

                   <div class="form-group" >
                        <label for="Surname">Investment Yield:</label>
                        <input type="text" name="investment_yield" class="form-control" v-model="newUnit.investment_yield" />
                        <span v-if="formErrors['investment_yield']" class="error text-danger">@{{ formErrors['investment_yield'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Availability:</label>
                        <input type="date" name="availability" class="form-control" v-model="newUnit.availability" />
                        <span v-if="formErrors['availability']" class="error text-danger">@{{ formErrors['availability'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Lease Start:</label>
                        <input type="date" name="lease_start" class="form-control" v-model="newUnit.lease_start" />
                        <span v-if="formErrors['lease_start']" class="error text-danger">@{{ formErrors['lease_start'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Lease End:</label>
                        <input type="date" name="lease_end" class="form-control" v-model="newUnit.lease_end" />
                        <span v-if="formErrors['lease_end']" class="error text-danger">@{{ formErrors['lease_end'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Active Agent:</label>

                        <select  id='agent_id' name='active_broker_id' class="form-control "  v-model="newUnit.active_broker_id" style="width: 100%;"  >
                           <option value="0" disabled  hidden>Please select agent...</option>
                               <option v-for="agent in agents" :value="agent.id"  >
                                    @{{ agent.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['active_broker_id']" class="error text-danger">@{{ formErrors['abroker'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Listing Agent:</label>

                        <select  id='agent_id' name='listing_broker_id' class="form-control "  v-model="newUnit.listing_broker_id" style="width: 100%;"  >
                           <option value="0" disabled  hidden>Please select agent...</option>
                               <option v-for="agent in agents" :value="agent.id"  >
                                    @{{ agent.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['listing_broker_id']" class="error text-danger">@{{ formErrors['lbroker'][0] }}</span>
                    </div>

              </div>

            <div class="modal-footer">
                  <!--  <button id="print" type="submit" class="btn btn-success">Print</button> -->
                  <button id="create-unit-submit" type="submit" class="btn btn-success">Submit</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
            </div>
          </div>
        </div>


        <div class="modal " id="edit-unit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form id="editUnit" method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateUnit(fillUnit.id)">
              <div class="modal-header">
                <button type="button" id="create-item-modal-header-button" class="close" data-dismiss="modal"  aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myCreateModalLabel">Edit Unit - <small>Erf @{{fillUnit.erf}}</small></h4>
              </div>
              <div class="modal-body">


                    @if ( Session::has('flash_message') )
                      <div class="alert {{ Session::get('flash_type') }} ">
                        <button type="button" class="form-group btn close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <p>{{ Session::get('flash_message') }}</p>
                      </div>
                    @endif

                    <div class="form-group">
                       <span v-if="formErrors['test']" class="error text-danger">@{{ formErrors['test'][0] }}</span>
                    </div>

                    <div class="form-group" hidden>
                        <label for="Surname">Id:</label>
                        <input type="text" name="id" class="form-control" v-model="fillUnit.id" readonly/>
                        <span v-if="formErrors['id']" class="error text-danger">@{{ formErrors['id'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Unit/Section:</label>
                        <input type="text" name="section" class="form-control" v-model="fillUnit.section" />
                        <span v-if="formErrors['section']" class="error text-danger">@{{ formErrors['section'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Property Type:</label>

                        <select  id='property_type_id' name='property_type_id' class="form-control "  v-model="fillUnit.property_type_id"  style="width: 100%;"  >
                           <option value="0" disabled  hidden>Please select property type...</option>
                               <option v-for="ptype in ptypes" :value="ptype.id"  >
                                    @{{ ptype.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['property_type_id']" class="error text-danger">@{{ formErrors['property_type_id'][0] }}</span>
                    </div>


                    <div class="form-group">
                        <label for="Firstname">Sale Type:</label>

                        <select  id='sale_type_id' name='sale_type_id' class="form-control "  v-model="fillUnit.sale_type_id"  style="width: 100%;"  >
                           <option value="0" disabled  hidden>Please select sale type...</option>
                               <option v-for="stype in stypes" :value="stype.id"  >
                                    @{{ stype.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['sale_type_id']" class="error text-danger">@{{ formErrors['sale_type_id'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Status:</label>

                        <select  id='status_id' name='status_id' class="form-control "  v-model="fillUnit.status_id"  style="width: 100%;"  >
                           <option value="0" disabled  hidden>Please select status...</option>
                               <option v-for="status in statuses" :value="status.id"  >
                                    @{{ status.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['status_id']" class="error text-danger">@{{ formErrors['status_id'][0] }}</span>
                    </div>


                    <div class="form-group" >
                        <label for="Surname">Size:</label>
                        <input type="text" name="size" class="form-control" v-model="fillUnit.size" />
                        <span v-if="formErrors['size']" class="error text-danger">@{{ formErrors['size'][0] }}</span>
                    </div>


                    <div class="form-group" >
                        <label for="Surname">Price:</label>
                        <input type="text" name="price" class="form-control" v-model="fillUnit.price" />
                        <span v-if="formErrors['price']" class="error text-danger">@{{ formErrors['price'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Gross Rental:</label>
                        <input type="text" name="gross_rental" class="form-control" v-model="fillUnit.gross_rental" />
                        <span v-if="formErrors['gross_rental']" class="error text-danger">@{{ formErrors['gross_rental'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Net Rental:</label>
                        <input type="text" name="net_rental" class="form-control" v-model="fillUnit.net_rental" />
                        <span v-if="formErrors['net_rental']" class="error text-danger">@{{ formErrors['net_rental'][0] }}</span>
                    </div>

                   <div class="form-group" >
                        <label for="Surname">Ops Costs:</label>
                        <input type="text" name="ops_costs" class="form-control" v-model="fillUnit.ops_costs" />
                        <span v-if="formErrors['ops_costs']" class="error text-danger">@{{ formErrors['ops_costs'][0] }}</span>
                    </div>

                   <div class="form-group" >
                        <label for="Surname">Rates:</label>
                        <input type="text" name="rates" class="form-control" v-model="fillUnit.rates" />
                        <span v-if="formErrors['rates']" class="error text-danger">@{{ formErrors['rates'][0] }}</span>
                    </div>

                   <div class="form-group" >
                        <label for="Surname">Investment Yield:</label>
                        <input type="text" name="investment_yield" class="form-control" v-model="fillUnit.investment_yield" />
                        <span v-if="formErrors['investment_yield']" class="error text-danger">@{{ formErrors['investment_yield'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Availability:</label>
                        <input type="date" name="availability" class="form-control" v-model="fillUnit.availability" />
                        <span v-if="formErrors['availability']" class="error text-danger">@{{ formErrors['availability'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Lease Start:</label>
                        <input type="date" name="lease_start" class="form-control" v-model="fillUnit.lease_start" />
                        <span v-if="formErrors['lease_start']" class="error text-danger">@{{ formErrors['lease_start'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Lease End:</label>
                        <input type="date" name="lease_end" class="form-control" v-model="fillUnit.lease_end" />
                        <span v-if="formErrors['lease_end']" class="error text-danger">@{{ formErrors['lease_end'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Active Agent:</label>

                        <select  id='agent_id' name='active_broker_id' class="form-control "  v-model="fillUnit.active_broker_id" style="width: 100%;"  >
                           <option value="0" disabled  hidden>Please select agent...</option>
                               <option v-for="agent in agents" :value="agent.id"  >
                                    @{{ agent.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['active_broker_id']" class="error text-danger">@{{ formErrors['abroker'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Listing Agent:</label>

                        <select  id='agent_id' name='listing_broker_id' class="form-control "  v-model="fillUnit.listing_broker_id" style="width: 100%;"  >
                           <option value="0" disabled  hidden>Please select agent...</option>
                               <option v-for="agent in agents" :value="agent.id"  >
                                    @{{ agent.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['listing_broker_id']" class="error text-danger">@{{ formErrors['lbroker'][0] }}</span>
                    </div>

              </div>

            <div class="modal-footer">
                  <!--  <button id="print" type="submit" class="btn btn-success">Print</button> -->
                  <button id="edit-unit-submit" type="submit" class="btn btn-success">Submit</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
            </div>
          </div>
        </div>


        <div class="modal " id="edit-note" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form id="createNote" method="POST" enctype="multipart/form-data" v-on:submit.prevent="createNote">
              <div class="modal-header">
                <button type="button" id="create-note-modal-header-button" class="close" data-dismiss="modal"  aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myCreateModalLabel">Notes  - <small>Erf @{{fillNote.erf}}</small></h4>
              </div>
              <div class="modal-body">




                    @if ( Session::has('flash_message') )
                      <div class="alert {{ Session::get('flash_type') }} ">
                        <button type="button" class="form-group btn close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <p>{{ Session::get('flash_message') }}</p>
                      </div>
                    @endif

                    <div class="form-group">
                       <span v-if="formErrors['test']" class="error text-danger">@{{ formErrors['test'] }}</span>
                    </div>

                    <div class="form-group" hidden>
                        <label for="Surname">Id:</label>
                        <input type="text" name="id" class="form-control" v-model="fillNote.id" readonly/>
                        <span v-if="formErrors['id']" class="error text-danger">@{{ formErrors['id'] }}</span>
                    </div>



                    <div class="form-group" hidden>
                        <label for="Surname">Unit Id:</label>
                        <input type="text" name="unit_id" class="form-control" v-model="fillNote.unit_id" readonly/>
                        <span v-if="formErrors['unit_id']" class="error text-danger">@{{ formErrors['unit_id'] }}</span>
                    </div>

                    <div id="notetable" style="height:180px;width:100%;border:1px solid #ccc;overflow:auto; padding:0px">


                        <table class="table  table-hover"  >

                            <tr v-for="item  in orderBy(fillNote.note, 'date', -1)   " v-if=" item.unit_id == fillNote.unit_id ">
                          <!--  == for online === for local <tr v-for="item  in fillNote.note | orderBy 'unit_id' -1 | orderBy 'date' -1" v-if=" item.unit_id === fillNote.unit_id "> -->
                                <td style="white-space:pre-wrap ; word-wrap:break-word;">Unit @{{ item.unit_id  }} <blue> @{{  item.date |  dateFrom }}  <red>@{{ userName(item.user_id)  }}</red></blue><br>@{{ item.description }}</td>

                            </tr>

                        </table>

                    </div>

                    <div>
                    <br>
                    </div>

                    <div class="form-group">

                        <textarea type="text" name="newnote" class="form-control" placeholder="Add note ..." v-model="fillNote.newnote" ></textarea>
                        <span v-if="formErrors['note']" class="error text-danger">@{{ formErrors['note'] }}</span>

                    </div>

            </div>
            <div class="modal-footer">
                <!--  <button id="print" type="submit" class="btn btn-success">Print</button> -->
                  <button id="edit-note-submit" type="submit" class="btn btn-success">Submit</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
            </div>
          </div>
        </div>

        <div class="modal " id="edit-owner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form id="createOwner" method="POST" enctype="multipart/form-data" v-on:submit.prevent="createOwner">
              <div class="modal-header">
                <button type="button" id="create-note-modal-header-button" class="close" data-dismiss="modal"  aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myCreateModalLabel">Contacts  - <small>Erf @{{fillOwner.erf}}</small></h4>
              </div>
              <div class="modal-body">




                    @if ( Session::has('flash_message') )
                      <div class="alert {{ Session::get('flash_type') }} ">
                        <button type="button" class="form-group btn close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <p>{{ Session::get('flash_message') }}</p>
                      </div>
                    @endif

                    <div class="form-group">
                       <span v-if="formErrors['test']" class="error text-danger">@{{ formErrors['test'] }}</span>
                    </div>

                    <div class="form-group" hidden>
                        <label for="Surname">Id:</label>
                        <input type="text" name="id" class="form-control" v-model="fillOwner.id" readonly/>
                        <span v-if="formErrors['id']" class="error text-danger">@{{ formErrors['id'] }}</span>

                    </div>

                    <div class="form-group" hidden>
                        <label for="Surname">Unit Id:</label>
                        <input type="text" name="unit_id" class="form-control" v-model="fillOwner.unit_id" readonly/>
                        <span v-if="formErrors['unit_id']" class="error text-danger">@{{ formErrors['unit_id'] }}</span>
                    </div>

                    <div id="ownertable" style="height:160px;width:100%;border:1px solid #ccc;overflow:auto; padding:0px">


                        <table class="table  table-hover">
                            <tr>

                                <th width="200px">Type</th>
                                <th width="200px">Company</th>
                                <th width="200px">Firstname</th>
                                <th width="200px">Lastname</th>
                                <th width="120px">Tel</th>
                                <th width="120px">Cell</th>
                                <th width="220px">Email</th>
                                <th width="220px">Website</th>
                                <th width="100px">Unit</th>
                                <th width="180px">Date</th>

                            </tr>
                           <!--    == for online === for local  <tr v-for="item  in fillOwner.owners | orderBy 'unit_id' -1 | orderBy 'date' -1" v-if=" item.unit_id === fillOwner.unit_id "> -->
                            <tr v-for="item  in orderBy(fillOwner.owners, 'created_at', -1) " v-if=" item.unit_id == fillOwner.unit_id ">


                                 <td>@{{ contacttypes[item.contact_type_id-1].name }}</td>
                                 <td>@{{ contacts[getContactId(item.contact_id)].company }}</td>
                                 <td>@{{ contacts[getContactId(item.contact_id)].firstname }}</td>
                                 <td>@{{ contacts[getContactId(item.contact_id)].lastname }}</td>
                                 <td>@{{ contacts[getContactId(item.contact_id)].tel }}</td>
                                 <td>@{{ contacts[getContactId(item.contact_id)].cell }}</td>
                                 <td><a :href="'mailto:'+item.email">@{{ contacts[getContactId(item.contact_id)].email }}</a></td>
                                 <td><a :href="'http://'+item.website" target="_blank">@{{contacts[getContactId(item.contact_id)].website }}</a></td>
                                 <td>@{{ item.unit_id }}</td>
                                 <td>@{{ item.created_at | dateNormal }}</td>
                            </tr>
                        </table>

                    </div>
                    <div>
                     <br>
                     </div>

                    @if ( Auth::user()->getRoleName()  == "Admin")

                        <div class="form-group">

                            <label for="Surname">  Existing Contact:</label><input type="radio" name="checkbox" value="true" v-model="checked" style="margin-left:20px;margin-right:20px;">
                            <label for="Surname">  New Contact:</label> <input type="radio" name="checkbox" value="false" v-model="checked" style="margin-left:20px;">
                            <div v-show="checked=='true'">
                            <!-- v-on:change="setContact(fillOwner.selectedContact)"   -->
                                <select  id ='unitowner'  name ='unitowner' class="form-control selectpicker"  data-live-search="true" data-width="100%" data-size="5" title="Select contact"  v-model="fillOwner.selectedContact">

                                       <option v-for="contact in contacts" v-bind:value="contact.id" :data-subtext="contact.email+' '+contact.cell" >
                                            @{{ contact.company }}
                                       </option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="Surname">Contact Type:</label>
                            <select  id ='contact_type_id'  name ='contact_type_id' class="form-control selectpicker"   data-width="100%" title="Select contact type"   v-model="fillOwner.contact_type_id" >

                                   <option v-for="contacttype in contacttypes" v-bind:value="contacttype.id"  >
                                        @{{ contacttype.name }}
                                   </option>
                            </select>
                            <span v-if="formErrors['contact_type_id']" class="error text-danger">@{{ formErrors['contact_type_id'][0] }}</span>
                        </div>

                        <div v-show="checked=='false'">
                            <div class="form-group">
                                <label for="Surname">Company:</label>
                                <input type="text" name="company" class="form-control" placeholder="Add company name, leave empty for private entity" v-model="fillOwner.company" />
                                <span v-if="formErrors['company']" class="error text-danger">@{{ formErrors['company'][0] }}</span>

                            </div>
                            <div class="form-group">
                                <label for="Surname">Firstname:</label>
                                <input type="text" name="firstname" class="form-control" placeholder="Add firstname " v-model="fillOwner.firstname" />
                                <span v-if="formErrors['firstname']" class="error text-danger">@{{ formErrors['firstname'][0] }}</span>

                            </div>

                            <div class="form-group">
                                <label for="Surname">Lastname:</label>
                                <input type="text" name="lastname" class="form-control" placeholder="Add lastname " v-model="fillOwner.lastname" />
                                <span v-if="formErrors['lastname']" class="error text-danger">@{{ formErrors['lastname'][0] }}</span>

                            </div>

                            <div class="form-group">
                                <label for="Surname">Tel:</label>
                                <input type="text" name="tel" class="form-control" placeholder="Add contact tel" v-model="fillOwner.tel" />
                                <span v-if="formErrors['tel']" class="error text-danger">@{{ formErrors['tel'][0] }}</span>

                            </div>

                            <div class="form-group">
                                <label for="Surname">Cell:</label>
                                <input type="text" name="cell" class="form-control" placeholder="Add contact cell" v-model="fillOwner.cell" />
                                <span v-if="formErrors['cell']" class="error text-danger">@{{ formErrors['cell'][0] }}</span>

                            </div>

                            <div class="form-group">
                                <label for="Surname">Email:</label>
                                <input type="text" name="email" class="form-control" placeholder="Add contact email" v-model="fillOwner.email" />
                                <span v-if="formErrors['email']" class="error text-danger">@{{ formErrors['email'][0] }}</span>

                            </div>

                            <div class="form-group">
                                <label for="Surname">Website:</label>
                                <input type="text" name="website" class="form-control" placeholder="Add website address" v-model="fillOwner.website" />
                                <span v-if="formErrors['website']" class="error text-danger">@{{ formErrors['website'][0] }}</span>

                            </div>
                        </div>

                    @endif

              </div>
              <div class="modal-footer">
                <!--  <button id="print" type="submit" class="btn btn-success">Print</button> -->
                 <button id="edit-owner-submit" type="submit" class="btn btn-success">Submit</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
            </div>
          </div>
        </div>




  <!-- Modal -->
  <div class="modal fade" id="listBrochures_modal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Print Brochures </h4>
        </div>
        <div class="modal-body">


                <div id="ownertable" style="height:320px;width:100%;border:1px solid #ccc;overflow:auto; padding:0px">
                        <table class="table  table-hover">
                            <tr>
                            <th width="20px">#</th>
                                <th width="80px">Erf</th>
                                <th width="100px">Unit</th>
                                <th width="300px">Address</th>
                                <th width="150px">Status</th>
                                <th width="150px">Type</th>
                                <th width="200px">Action</th>


                            </tr>
                           <!--    == for online === for local  <tr v-for="item  in fillOwner.owners | orderBy 'unit_id' -1 | orderBy 'date' -1" v-if=" item.unit_id === fillOwner.unit_id "> -->

                            <tr v-for="item,key in brochures"  v-if="inArray(user,item.brochure_users)" >

                                 <td>@{{ key+1}}</td>
                                 <td>@{{ item.property.erf }} </td>
                                 <td>@{{ item.id }}</td>
                                 <td>@{{ item.property.address }}</td>
                                 <td>@{{ statusName(item.status_id) }}</td>
                                 <td>@{{ propertyTypeName(item.property_type_id) }}</td>

                                 <td><button title="Brochure On"  class="btn btn-danger btn-xs pull right"   @click.prevent="setBrochure(item.property,item)"><span class="glyphicon glyphicon-remove"></span>  </button></td>

                            </tr>

                        </table>
                 </div>

                <br>

                 <form id="listBrochures" method="GET"  v-on:submit.prevent="createPDF">
                    <div class="form-group">
                        <label for="Firstname">Agent:</label>

                        <select  id='agent' name='agent' class="form-control "  v-model="agent" style="width: 100%;"  >
                           <option value="0" disabled  hidden>Please select agent...</option>
                               <option v-for="agent in agents" :value="agent.id"  >
                                    @{{ agent.name }}
                               </option>
                        </select>
                    </div>
                    <div class="form-group" >
                        <label for="Surname">Presentation For:</label>
                        <input type="text" id="client" name="client" placeholder="Client name.." class="form-control" />
                    </div>

                    <div class="form-group" >
                      <label for="Surname">Client Brief:</label>
                      <textarea type="text" id="brochure_text" name="brochure_text" class="form-control" placeholder="Add presentation text ..."  ></textarea>
                    </div>


                    <div class="form-group">
                        <label for="Firstname">Brochure:</label>
                       <select  id ='brochure_type' name ='brochure_type' class="form-control "   data-width="100%"   >
                               <option  v-bind:value='0'  > Format 1 </option>
                              <!--  <option  v-bind:value='1'  > Format 2 </option>  -->
                        </select>

                    </div>

        </div>

        <div class="modal-footer">

        <!--  <button id="print" type="submit" class="btn btn-success">Print</button> -->
          <button class="btn btn-success " @click.prevent="createPDF">Print</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>




 </div>



    <!--<script src="js/properties.js"></script>-->
    <script type="text/javascript" src="js/properties.js" ></script>




    @endsection
