
@extends('layouts.app')


@section('content')



     <!-- select2 -->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.css" media="all" rel="stylesheet" type="text/css" />
     <!-- CSS to make Select2 fit in with Bootstrap 3.x -->
     <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.0/select2-bootstrap.min.css" />
     <!-- toastr -->
     <link href="https://cdn.jsdelivr.net/toastr/2.1.3/toastr.min.css" rel="stylesheet">

     <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css rel="stylesheet">

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

        color:black;
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
    position:relative;
    top:-22px;

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
    z-index:30;
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
#itemdetails table tbody tr td {
    border: none  !important;
       border-top: none !important;
    border-left: none !important;
    border-bottom: none !important;
    background-color:white;
}
</style>


 <div  v-cloak id="manage-properties">



<div class=" searchbar col-md-12 ">

<div class=" col-md-12  ">
<div class="row ">
<form id='search' class="form-inline form-group col-md-offset-1" method="POST" enctype="multipart/form-data" v-on:submit.prevent="searchVueItems">

<br>
                        <input id='s_erf' type="text"  class="form-control" style="width:100px" placeholder="Erf" v-model="s_erf" />

                        <select  id ='s_area'  name='s_area' class="form-control "   v-model="s_area"   >
                           <option value="0"  selected >All areas</option>
                               <option v-for="area in areas" v-bind:value="area.id"  >
                                    @{{ area.name }}
                               </option>
                        </select>

                        <select  id ='s_ptype'  class="form-control "   v-model="s_ptype"    >
                           <option value="0"  selected >All properties</option>
                               <option v-for="ptype in ptypes" v-bind:value="ptype.id"  >
                                    @{{ ptype.name }}
                               </option>
                        </select>

                        <select  id ='s_stype' class="form-control "   v-model="s_stype"    >
                           <option value="0"  selected >Rentals and sales</option>
                               <option v-for="stype in stypes" v-bind:value="stype.id"  >
                                    @{{ stype.name }}
                               </option>
                        </select>

                        <input id='s_minsize' type="text" name="id" class="form-control" style="width:100px" placeholder="min size" v-model="s_minsize" />

                        <input id='s_maxsize' type="text" name="id" class="form-control" style="width:100px" placeholder="max size" v-model="s_maxsize"  />

                          <label>
                            {!! Form::submit('Search',array('class'=>'btn btn-primary')) !!}

                          </label>
                        <button class="btn btn-success " @click.prevent="resetSearch()">Reset</button>

   </form>
</div>
</div>
</div>

 <div class=" col-md-10 col-md-offset-1" >
        <!-- Pagination -->
<div class="row ">



        <!-- Pagination -->
        <nav>
            <ul class="pagination .pagination-sm">
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





<div class="items" v-for="item in items">



    <h1>@{{ item.title }}</h1>
    <p>@{{ areas[item.area_id-1].name }}</p>
    <div class=" row border myprop" >

             <div class='prop_img col-sm-4'>

                 <img :src="offlinePath+'/commprop/public/property/'+item.id+'/'+ item.images[0].name  " width="98%"  >
                 <div class='caption'>
                 <p class="captiontext"> @{{ item.images[0].caption }}</p>
                    <a href="showproperty@{{item.id}}" class="camera"> <span class="glyphicon glyphicon-camera"></span> </a>
                 </div>

             </div>

            <div class='descrip col-sm-8'>
            <div style="height:210px;width:100%;border:0px solid #ccc;overflow:auto; padding:0px">
            <p class="red" >Erf: @{{ item.erf }}     <i class="spanUser">  </i><a a href="showproperty@{{item.id}}"}}>Id: @{{ item.id }}</a></p>
                @{{ item.description }}
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

           <button id="notes_button" class="btn btn-warning btn-xs" @click.prevent="editNote(item,unit)">Notes</button>
           <button class="btn btn-info btn-xs" @click.prevent="editOwner(item,unit)">Owners</button>

           <button class="btn btn-default btn-xs" @click.prevent="createPDF(item)">Brochure</button>
     </div>


        <div id="myDIV"  >

             <div id="itemdetails" class=" table-responsive table-no-bordered" width="350" style="overflow-x:auto; width:350px;">
                <table  class="table  ">

                     <tbody>
                     <tr>
                         <td v-if="seen" width="150">Type   </td>
                         <td v-if="seen" width="200">@{{ item.type }}</td>
                     </tr>
                     <tr>
                         <td v-if="seen" >Status   </td>
                         <td v-if="seen">@{{ item.status }}</td>
                     </tr>
                     <tr>
                         <td v-if="seen" >Grade   </td>
                         <td v-if="seen">@{{ item.grade }}</td>
                     </tr>
                     <tr>
                         <td v-if="seen" >Erf Size   </td>
                         <td v-if="seen"></td>
                     </tr>
                     <tr>
                         <td v-if="seen" width="100">Building Size   </td>
                         <td v-if="seen"></td>
                     </tr>
                     <tr>
                         <td v-if="seen" width="100">Parking Ratio   </td>
                         <td v-if="seen"></td>
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
                            <th width="80px" class="hidden-xs">Unit ID</th>
                            <th width="180px">Type</th>
                            <th width="180px">Size</th>
                            <th width="180px">Price</th>
                            <th width="220px">Actions</th>

                         </tr>
                     </thead>
                     <tbody>
                        <tr v-for="unit in item.units">
                            <td class="hidden-xs">
                                Unit  @{{ unit.id }}
                            </td>
                            <td>
                                @{{  ptypes[ unit.property_type_id -1].name }}

                            </td>
                            <td>
                                @{{ unit.size}}   m<sup>2</sup>
                            </td>
                            <td>
                                R @{{ unit.price}}  m<sup>2</sup>
                            </td>
                            <td class="actions">
                               <button class="btn btn-warning btn-xs pull right" @click.prevent="editNote(item,unit)">Notes</button>
                               <button class="btn btn-info btn-xs pull right" @click.prevent="editOwner(item,unit)">Owner</button>
                               @if ( Auth::user()->getRoleName()  == "Admin")
                                   <button class="btn btn-danger btn-xs pull right" @click.prevent="deleteUnit(unit)">Delete</button>
                               @endif

                                 <a href="showunit@{{unit.id}}" class="btn btn-default btn-xs pull right" role="button">Details</a>
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
              <div class="modal-header">
                <button type="button" id="create-item-modal-header-button" class="close" data-dismiss="modal"  aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myCreateModalLabel">Create Property</h4>
              </div>
              <div class="modal-body">

                    <form id="createProp" method="POST" enctype="multipart/form-data" v-on:submit.prevent="createItem">


                    @if ( Session::has('flash_message') )
                      <div class="alert {{ Session::get('flash_type') }} ">
                        <button type="button" class="form-group btn close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <p>{{ Session::get('flash_message') }}</p>
                      </div>
                    @endif

                    <div class="form-group">
                       <span v-if="formErrors['test']" class="error text-danger">@{{ formErrors['test'] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Erf Number:</label>
                        <input type="text" name="erf" class="form-control" v-model="newItem.erf" />
                        <span v-if="formErrors['erf']" class="error text-danger">@{{ formErrors['erf'] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Title:</label>
                        <input type="text" name="title" class="form-control" v-model="newItem.title" />
                        <span v-if="formErrors['title']" class="error text-danger">@{{ formErrors['title'] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Description:</label>
                        <textarea type="text" name="description" rows="5" class="form-control" v-model="newItem.description" ></textarea>
                        <span v-if="formErrors['description']" class="error text-danger">@{{ formErrors['description'] }}</span>

                    </div>

                    <div class="form-group">
                        <label for="Surname">Address:</label>
                        <textarea type="text" name="address" rows="5" class="form-control" v-model="newItem.address" ></textarea>
                        <span v-if="formErrors['address']" class="error text-danger">@{{ formErrors['address'] }}</span>

                    </div>

                    <div class="form-group">
                        <label for="Firstname">Area:</label>

                        <select  id ='area_id' name='area_id' class="form-control "  v-model="newItem.area_id"  style="width: 100%;"  >
                           <option value="" disabled selected hidden>Please select an area...</option>
                               <option v-for="area in areas" v-bind:value="area.id"  >
                                    @{{ area.name }}
                               </option>
                        </select>

                        <span v-if="formErrors['area_id']" class="error text-danger">@{{ formErrors['area_id'] }}</span>
                    </div>

                    <div class="form-group">
                    <label for="Firstname">Image:</label>

                        <input type="file" id="image" name="image[]" multiple  @change="getImage"/>

                        <span v-if="formErrors['image']" class="error text-danger">@{{ formErrors['image'] }}</span>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>

                    </form>

              </div>
            </div>
          </div>
        </div>

        <!-- Edit Item Modal -->
        <div class="modal fade" id="edit-item" tabindex="-1050" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Property  - <small>Erf @{{fillItem.erf}}</small></h4>
              </div>
              <div class="modal-body">

                    <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id)">

                    <div class="form-group">
                       <span v-if="formErrorsUpdate['test']" class="error text-danger">@{{ formErrorsUpdate['test'] }}</span>
                    </div>

                    <div class="form-group" hidden>
                        <label for="Surname">Id:</label>
                        <input type="text" name="id" class="form-control" v-model="fillItem.id" />
                        <span v-if="formErrorsUpdate['id']" class="error text-danger">@{{ formErrorsUpdate['id'] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Erf Number:</label>
                        <input type="text" name="erf" class="form-control" v-model="fillItem.erf" />
                        <span v-if="formErrorsUpdate['erf']" class="error text-danger">@{{ formErrorsUpdate['erf'] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Title:</label>
                        <input type="text" name="title" class="form-control" v-model="fillItem.title" />
                        <span v-if="formErrorsUpdate['title']" class="error text-danger">@{{ formErrorsUpdate['title'] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Description:</label>
                        <textarea type="text" name="description" rows="5" class="form-control" v-model="fillItem.description"  ></textarea>
                        <span v-if="formErrorsUpdate['description']" class="error text-danger">@{{ formErrorsUpdate['description'] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Surname">Address:</label>
                        <textarea type="text" name="address" rows="5" class="form-control" v-model="fillItem.address" ></textarea>
                        <span v-if="formErrorsUpdate['address']" class="error text-danger">@{{ formErrorsUpdate['address'] }}</span>

                    </div>

                    <div class="form-group">
                        <label for="Firstname">Area:</label>

                        <select  id ='area_id' name='area_id' class="form-control "  v-model="fillItem.area_id"  style="width: 100%;"  >
                               <option value="null" disabled selected hidden>Please select an area...</option>
                               <option v-for="area in areas" value=" @{{ area.id }}" >
                                    @{{ area.name }}
                               </option>
                        </select>

                        <span v-if="formErrorsUpdate['area_id']" class="error text-danger">@{{ formErrorsUpdate['area_id'] }}</span>
                    </div>


                    <div style="height:330px;width:100%;border:1px solid #ccc;overflow:auto; padding:0px">


                            <ul  class="list-group"  v-sortable  >


                                 <li class="list-group-item"  v-for="item  in fillItem.image " ><img :src="offlinePath+'/commprop/public/property/'+fillItem.id+'/'+ item.name  " width="80px" /> </li>


                            </ul>

                    </div>


                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>

                    </form>

              </div>
            </div>
          </div>
        </div>


        <div class="modal " id="create-unit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" id="create-item-modal-header-button" class="close" data-dismiss="modal"  aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myCreateModalLabel">Add Unit - <small>Erf @{{fillItem.erf}}</small></h4>
              </div>
              <div class="modal-body">

                    <form id="createUnit" method="POST" enctype="multipart/form-data" v-on:submit.prevent="createUnit">


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
                        <input type="text" name="id" class="form-control" v-model="newItem.id" readonly/>
                        <span v-if="formErrors['id']" class="error text-danger">@{{ formErrors['id'] }}</span>
                    </div>



                    <div class="form-group">
                        <label for="Firstname">Property Type:</label>

                        <select  id='property_type_id' class="form-control "  v-model="newUnit.property_type_id"  style="width: 100%;"  >
                           <option value="" disabled selected hidden>Please select property type...</option>
                               <option v-for="ptype in ptypes" value=" @{{ ptype.id }}"  >
                                    @{{ ptype.name }}
                               </option>
                        </select>


                        <span v-if="formErrors['property_type_id']" class="error text-danger">@{{ formErrors['property_type_id'] }}</span>
                    </div>


                    <div class="form-group">
                        <label for="Firstname">Sale Type:</label>

                        <select  id='sale_type_id' class="form-control "  v-model="newUnit.sale_type_id"  style="width: 100%;"  >
                           <option value="" disabled selected hidden>Please select sale type...</option>
                               <option v-for="stype in stypes" value=" @{{ stype.id }}"  >
                                    @{{ stype.name }}
                               </option>
                        </select>


                        <span v-if="formErrors['sale_type_id']" class="error text-danger">@{{ formErrors['sale_type_id'] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Size:</label>
                        <input type="text" name="size" class="form-control" v-model="newUnit.size" />
                        <span v-if="formErrors['size']" class="error text-danger">@{{ formErrors['size'] }}</span>
                    </div>


                    <div class="form-group" >
                        <label for="Surname">Price:</label>
                        <input type="text" name="price" class="form-control" v-model="newUnit.price" />
                        <span v-if="formErrors['price']" class="error text-danger">@{{ formErrors['price'] }}</span>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>

                    </form>

              </div>
            </div>
          </div>
        </div>


        <div class="modal " id="edit-note" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" id="create-note-modal-header-button" class="close" data-dismiss="modal"  aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myCreateModalLabel">Notes  - <small>Erf @{{fillNote.erf}}</small></h4>
              </div>
              <div class="modal-body">

                    <form id="createNote" method="POST" enctype="multipart/form-data" v-on:submit.prevent="createNote">


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

                            <tr v-for="item  in fillNote.note | orderBy 'unit_id' -1 | orderBy 'date' -1" v-if=" item.unit_id == fillNote.unit_id ">
                                <td style="white-space:pre-wrap ; word-wrap:break-word;">Unit @{{ item.unit_id  }} <blue> @{{  item.date |  dateFrom }}  <red>@{{ users[ item.user_id -1 ].name  }}</red></blue><br>@{{ item.description }}</td>

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


                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>

                    </form>

              </div>
            </div>
          </div>
        </div>

        <div class="modal " id="edit-owner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" id="create-note-modal-header-button" class="close" data-dismiss="modal"  aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myCreateModalLabel">Owners  - <small>Erf @{{fillOwner.erf}}</small></h4>
              </div>
              <div class="modal-body">

                    <form id="createOwner" method="POST" enctype="multipart/form-data" v-on:submit.prevent="createOwner">


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

                    <div style="height:130px;width:100%;border:1px solid #ccc;overflow:auto; padding:0px">


                        <table class="table  table-hover">
                            <tr>


                                <th width="200px">Owner</th>
                                <th width="120px">Tel</th>
                                <th width="120px">Cell</th>
                                <th width="220px">Email</th>
                                <th width="100px">Unit</th>
                                <th width="180px">Date</th>

                            </tr>
                            <tr v-for="item  in fillOwner.owners | orderBy 'unit_id' -1 | orderBy 'date' -1" v-if=" item.unit_id == fillOwner.unit_id ">


                                 <td>@{{ item.contact }}</td>
                                 <td>@{{ item.tel }}</td>
                                 <td>@{{ item.cell }}</td>
                                 <td>@{{ item.email }}</td>
                                 <td>@{{ item.unit_id }}</td>
                                 <td>@{{ item.date | dateNormal }}</td>
                            </tr>
                        </table>

                    </div>
                    <div>
                     <br>
                     </div>

@if ( Auth::user()->getRoleName()  == "Admin")

                    <div class="form-group">
                        <label for="Surname">Contact:</label>
                        <input type="text" name="contact" class="form-control" placeholder="Add contact name" v-model="fillOwner.contact" />
                        <span v-if="formErrors['contact']" class="error text-danger">@{{ formErrors['contact'] }}</span>

                    </div>

                    <div class="form-group">
                        <label for="Surname">Tel:</label>
                        <input type="text" name="tel" class="form-control" placeholder="Add contact tel" v-model="fillOwner.tel" />
                        <span v-if="formErrors['tel']" class="error text-danger">@{{ formErrors['tel'] }}</span>

                    </div>

                    <div class="form-group">
                        <label for="Surname">Cell:</label>
                        <input type="text" name="cell" class="form-control" placeholder="Add contact cell" v-model="fillOwner.cell" />
                        <span v-if="formErrors['cell']" class="error text-danger">@{{ formErrors['cell'] }}</span>

                    </div>

                    <div class="form-group">
                        <label for="Surname">Email:</label>
                        <input type="text" name="email" class="form-control" placeholder="Add contact email" v-model="fillOwner.email" />
                        <span v-if="formErrors['email']" class="error text-danger">@{{ formErrors['email'] }}</span>

                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>

                    </form>
@endif

              </div>
            </div>
          </div>
        </div>


 </div>



    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/vue.resource/0.9.3/vue-resource.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/toastr/2.1.3/toastr.min.js"></script>


    <!--<script src="js/properties.js"></script>-->
    <script type="text/javascript" src="{!! asset('js/properties.js') !!}"></script>


    @endsection
