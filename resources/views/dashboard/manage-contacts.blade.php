
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

.modal-header {
    background-color: #008DB7;
}

.modal-body {
   background-color: WhiteSmoke ;
}

.modal-title {

color:white;
}
</style>
@section('content')


     <!-- toastr -->
     <link href="https://cdn.jsdelivr.net/toastr/2.1.3/toastr.min.css" rel="stylesheet">


    <link href="css/bootstrap-select.css" rel="stylesheet">




    <div v-cloak class="w3-container"  id="manage-contacts">


  <!-- Header -->
  <header class="w3-container" style="padding-top:42px">
    <h5><b><i class="fa fa-dashboard"></i> Contacts</b></h5><br>
  </header>


<!--
         <div class="w3-container ">
                <div class="col-lg-6 margin-tb pull-left" >
                    <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="searchVueItems">
                             <div id="custom-search-input" >
                               <div class="input-group ">
                                <input type="text" name="Search" class="form-control" v-model="search.string" placeholder="Search ID Number"/>
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-info">
                                         <span class=" glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                                </div>
                             </div>
                    </form>
                </div>
        </div>
-->

        <div class="w3-container ">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2></h2>
                </div>

                 <div class="pull-right">
                    <a href="{{ URL::route('exportContacts') }}" class="btn btn-warning"> Export Contacts</a>
                    <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#">
                      @{{pagination.total}} Records
                    </button>

                </div>

                <div class="pull-left">
                    <button type="button" class="btn btn-success btn-md" @click.prevent="createForms">
                      New Contact
                    </button>
                </div>

            </div>

        </div>


        <!-- Item Listing -->
        <div class="w3-container" style="overflow-x:auto;">
            <br>
            <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
                <tr>
                    <th width="200px">Action</th>
                    <th width="130px">Company</th>
                    <th width="130px">FirstName</th>
                    <th width="130px">LastName</th>
                    <th width="120px">Email</th>
                    <th width="120px">Tel</th>
                    <th width="120px">Cell</th>
                    <th width="130px">Website</th>

                </tr>
                <tr v-for="item in items">
                    <td >
                    @if ( Auth::user()->getRoleName()  == "Admin"  ||  Auth::user()->getRoleName()  == "System")
                      <button class="btn btn-primary btn-xs" @click.prevent="editItem(item)">Edit</button>

                    @if ( Auth::user()->getRoleName()  == "System")
                      <button class="btn btn-danger btn-xs" @click.prevent="deleteItem(item)">Delete</button>
                    @endif

                    @endif
                      <button class="btn btn-default btn-xs" @click.prevent="viewProperties(item.id)">Properties</button>
                    </td>
                    <td>@{{ item.company }}</td>
                    <td>@{{ item.firstname }}</td>
                    <td>@{{ item.lastname }}</td>
                    <td>@{{ item.email}}</td>
                    <td>@{{ item.tel}}</td>
                    <td>@{{ item.cell }}</td>
                    <td>@{{ item.website }}</td>

                </tr>
            </table>
        </div>





        <!-- Pagination -->
        <div class="w3-container pull-right" >
        <nav>
            <ul class="pagination .pagination-sm">
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
             <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="createItem">
              <div class="modal-header">
                <button type="button" id="create-item-modal-header-button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">New Contact</h4>
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
                        <label for="strIDNumber">Company:</label>
                        <input type="text" name="company" class="form-control" v-model="newItem.company" />
                        <span v-if="formErrors['company']" class="error text-danger">@{{ formErrors['company'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strIDNumber">FirstName:</label>
                        <input type="text" name="firstname" class="form-control" v-model="newItem.firstname" />
                        <span v-if="formErrors['firstname']" class="error text-danger">@{{ formErrors['firstname'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strIDNumber">LastName:</label>
                        <input type="text" name="lastname" class="form-control" v-model="newItem.lastname" />
                        <span v-if="formErrors['lastname']" class="error text-danger">@{{ formErrors['lastname'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strSurname">Email:</label>
                        <input type="text" name="email" class="form-control" v-model="newItem.email" />
                        <span v-if="formErrors['email']" class="error text-danger">@{{ formErrors['email'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strSurname">Tel:</label>
                        <input type="text" name="tel" class="form-control" v-model="newItem.tel" />
                        <span v-if="formErrors['tel']" class="error text-danger">@{{ formErrors['tel'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strSurname">Cell:</label>
                        <input type="text" name="cell" class="form-control" v-model="newItem.cell" />
                        <span v-if="formErrors['cell']" class="error text-danger">@{{ formErrors['cell'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strSurname">Website:</label>
                        <input type="text" name="website"  class="form-control" v-model="newItem.website" />
                        <span v-if="formErrors['website']" class="error text-danger">@{{ formErrors['website'][0] }}</span>
                    </div>

                 </div>


                <div class="form-group modal-footer">
                          <!--  <button id="print" type="submit" class="btn btn-success">Print</button> -->
                        <button id="create-item-submit" type="submit" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </form>


            </div>
          </div>
        </div>

        <!-- Edit Item Modal -->
        <div class="modal fade" id="edit-item" tabindex="-1050" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id)">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Contact</h4>
              </div>
              <div class="modal-body">


                    <div class="form-group">
                       <span v-if="formErrorsUpdate['test']" class="error text-danger">@{{ formErrorsUpdate['test'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strIDNumber">Company:</label>
                        <input type="text" name="company" class="form-control" v-model="fillItem.company" />
                        <span v-if="formErrorsUpdate['company']" class="error text-danger">@{{ formErrorsUpdate['company'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strIDNumber">FirstName:</label>
                        <input type="text" name="firstname" class="form-control" v-model="fillItem.firstname" />
                        <span v-if="formErrorsUpdate['firstname']" class="error text-danger">@{{ formErrorsUpdate['firstname'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strIDNumber">LastName:</label>
                        <input type="text" name="lastname" class="form-control" v-model="fillItem.lastname" />
                        <span v-if="formErrorsUpdate['lastname']" class="error text-danger">@{{ formErrorsUpdate['lastname'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strSurname">Email:</label>
                        <input type="text" name="email" class="form-control" v-model="fillItem.email" />
                        <span v-if="formErrorsUpdate['email']" class="error text-danger">@{{ formErrorsUpdate['email'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strSurname">Cell:</label>
                        <input type="text" name="cell" class="form-control" v-model="fillItem.cell" />
                        <span v-if="formErrorsUpdate['cell']" class="error text-danger">@{{ formErrorsUpdate['cell'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strSurname">Tel:</label>
                        <input type="text" name="tel" class="form-control" v-model="fillItem.tel" />
                        <span v-if="formErrorsUpdate['tel']" class="error text-danger">@{{ formErrorsUpdate['tel'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strSurname">Website:</label>
                        <input type="text" name="website"  class="form-control" v-model="fillItem.website" />
                        <span v-if="formErrorsUpdate['website']" class="error text-danger">@{{ formErrorsUpdate['website'][0] }}</span>
                    </div>


                </div>
                <div class="form-group modal-footer">
                    <!--  <button id="print" type="submit" class="btn btn-success">Print</button> -->
                    <button id="create-item-submit" type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </form>

              </div>
            </div>
          </div>


      <!-- Edit Item Modal -->
        <div class="modal fade" id="view-properties" tabindex="-1050" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id)">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">View Contact's Properties </h4>
              </div>
              <div class="modal-body">


                    <div id="ownertable" style="height:160px;width:100%;border:1px solid #ccc;overflow:auto; padding:0px">



                            <div v-for="property  in properties" >


                                    <h4 class="w3-text-blue w3-padding">@{{ property.address }}</h4>

                                     <div v-for="owners  in property.owners" >
                                         <div v-if="owners.contact_id == fillItem.id">
                                            <div v-if="owners.unit_id == 0 ">
                                             <h5 class="w3-text-black w3-padding">  @{{ contactTypeName(owners.contact_type_id) }} - Main property</h5>
                                             </div>
                                             <div v-if="owners.unit_id > 0 ">
                                             <h5 class="w3-text-black w3-padding">  @{{ contactTypeName(owners.contact_type_id) }} - Unit : @{{ owners.unit_id }}</h5>
                                             </div>
                                        </div>
                                     </div>

                            </div>


                    </div>



                </div>
                <div class="form-group modal-footer">
                    <!--  <button id="print" type="submit" class="btn btn-success">Print</button> -->

                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </form>

              </div>
            </div>
          </div>


        </div>

    </div>



    <script type="text/javascript" src="{!! asset('js/contacts.js') !!}"></script>

    @endsection
