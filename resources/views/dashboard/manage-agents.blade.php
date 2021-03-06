
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

[v-cloak] { display: none; }

.modal-title {

color:white;
}
</style>
@section('content')


     <!-- toastr -->
     <link href="https://cdn.jsdelivr.net/toastr/2.1.3/toastr.min.css" rel="stylesheet">


    <link href="css/bootstrap-select.css" rel="stylesheet">




    <div  v-cloak class="w3-container" id="manage-agents">


  <!-- Header -->
  <header class="w3-container" style="padding-top:42px">
    <h5><b><i class="fa fa-dashboard"></i> Agents</b></h5><br>
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
                  @if ( Auth::user()->getRoleName()  == "Admin"  ||  Auth::user()->getRoleName()  == "System")
                    <a href="{{ URL::route('exportAgents') }}" class="btn btn-warning"> Export Agents</a>
                  @endif
                    <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#">
                      @{{pagination.total}} Records
                    </button>

                </div>

                <div class="pull-left">
                 @if ( Auth::user()->getRoleName()  == "Admin"  ||  Auth::user()->getRoleName()  == "System")
                    <button type="button" class="btn btn-success btn-md" @click.prevent="createForms">
                      New Agent
                    </button>
                 @endif
                </div>

            </div>

        </div>


        <!-- Item Listing -->
        <div class="w3-container" style="overflow-x:auto;">
            <br>
            <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
                <tr>
                    <th width="120px">Action</th>
                    <th width="130px">Name</th>
                    <th width="120px">Email</th>
                    <th width="120px">Tel</th>
                    <th width="120px">Cell</th>
                    <th width="120px">Photo</th>

                </tr>
                <tr v-for="item in items">
                    <td >
                      @if ( Auth::user()->getRoleName()  == "Admin"  ||  Auth::user()->getRoleName()  == "System")
                      <button class="btn btn-primary btn-xs" @click.prevent="editItem(item)">Edit</button>
                        @if (  Auth::user()->getRoleName()  == "System")
                      <button class="btn btn-danger btn-xs" @click.prevent="deleteItem(item)">Delete</button>
                      @endif
                      @endif
                    </td>
                    <td>@{{ item.name }}</td>
                    <td>@{{ item.email}}</td>
                    <td>@{{ item.tel}}</td>
                    <td>@{{ item.cell }}</td>
                     <td>@{{ item.photo }}</td>

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
             <form id="createAgent" method="POST" enctype="multipart/form-data" v-on:submit.prevent="createItem">
              <div class="modal-header">
                <button type="button" id="create-item-modal-header-button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">New Agent</h4>
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
                        <label for="strIDNumber">Name:</label>
                        <input type="text" name="name" class="form-control" v-model="newItem.name" />
                        <span v-if="formErrors['name']" class="error text-danger">@{{ formErrors['name'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strIDNumber">Title:</label>
                        <input type="text" name="title" class="form-control" v-model="newItem.title" />
                        <span v-if="formErrors['title']" class="error text-danger">@{{ formErrors['title'][0] }}</span>
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
                        <label for="strSurname">About:</label>
                        <textarea type="text" name="about" rows="5" class="form-control" v-model="newItem.about" ></textarea>
                        <span v-if="formErrors['about']" class="error text-danger">@{{ formErrors['about'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strSurname">Photo:</label>
                        <input type="file"  name="photo"   />
                        <span v-if="formErrors['photo']" class="error text-danger">@{{ formErrors['photo'][0] }}</span>
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
            <form id="editAgent" method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id)">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Agent</h4>
              </div>
              <div class="modal-body">


                    <div class="form-group">
                       <span v-if="formErrorsUpdate['test']" class="error text-danger">@{{ formErrorsUpdate['test'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strIDNumber">Name:</label>
                        <input type="text" name="name" class="form-control" v-model="fillItem.name" />
                        <span v-if="formErrorsUpdate['name']" class="error text-danger">@{{ formErrorsUpdate['name'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strIDNumber">Title:</label>
                        <input type="text" name="title" class="form-control" v-model="fillItem.title" />
                        <span v-if="formErrorsUpdate['title']" class="error text-danger">@{{ formErrorsUpdate['title'][0] }}</span>
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
                        <label for="strSurname">About:</label>
                        <textarea type="text" name="about" rows="5" class="form-control" v-model="fillItem.about" ></textarea>
                        <span v-if="formErrorsUpdate['about']" class="error text-danger">@{{ formErrorsUpdate['about'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strFirstName">Photo:</label>
                        <input type="file" name="photo" class="form-control"  />
                        <span v-if="formErrorsUpdate['photo']" class="error text-danger">@{{ formErrorsUpdate['photo'][0] }}</span>
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
        </div>

    </div>



    <script type="text/javascript" src="{!! asset('js/agents.js') !!}"></script>




    @endsection
