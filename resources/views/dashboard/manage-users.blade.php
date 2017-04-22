
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




    <div v-cloak class="w3-container" id="manage-users">


  <!-- Header -->
  <header class="w3-container" style="padding-top:42px">
    <h5><b><i class="fa fa-dashboard"></i> Users</b></h5><br>
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
                    <a href="{{ URL::route('exportUsers') }}" class="btn btn-warning"> Export Users</a>
                    <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#">
                      @{{pagination.total}} Records
                    </button>

                </div>

                <div class="pull-left">
                    <button type="button" class="btn btn-success btn-md" @click.prevent="createForms">
                      New User
                    </button>
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
                    <th width="120px">Agent</th>
                    <th width="300px">Role</th>

                </tr>
                <tr v-for="item in items">
                    <td >
                      <button class="btn btn-primary btn-xs" @click.prevent="editItem(item)">Edit</button>
                      <button class="btn btn-danger btn-xs" @click.prevent="deleteItem(item)">Delete</button>
                    </td>
                    <td>@{{ item.name }}</td>
                    <td>@{{ item.email}}</td>
                    <td>@{{ agentName(item.agent_id) }}</td>
                    <td>@{{ roleName(item.role_id) }}</td>

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
                <h4 class="modal-title" id="myModalLabel">New User</h4>
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
                        <label for="strSurname">Email:</label>
                        <input type="text" name="email" class="form-control" v-model="newItem.email" />
                        <span v-if="formErrors['email']" class="error text-danger">@{{ formErrors['email'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strSurname">Agent:</label>
                        <select  id='agent_id' name='agent_id' class="form-control "   v-model="newItem.agent_id"  style="width: 100%;"  >
                               <option v-for="agent in agents" :value="agent.id"  >
                                    @{{ agent.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['agent_id']" class="error text-danger">@{{ formErrors['agent_id'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strSurname">Role:</label>
                        <select  id='role_id' name='role_id' class="form-control "   v-model="newItem.role_id"  style="width: 100%;"  >
                               <option v-for="role in roles" :value="role.id"  >
                                    @{{ role.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['role_id']" class="error text-danger">@{{ formErrors['role_id'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strSurname">Password:</label>
                        <input type="password" name="password" class="form-control" v-model="newItem.password" />
                        <span v-if="formErrors['password']" class="error text-danger">@{{ formErrors['password'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strSurname">Confirm Password:</label>
                        <input type="password" name="password_confirmation" class="form-control" v-model="newItem.password_confirmation" />
                        <span v-if="formErrors['password_confirmation']" class="error text-danger">@{{ formErrors['password_confirmation'][0] }}</span>
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
                <h4 class="modal-title" id="myModalLabel">Edit User</h4>
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
                        <label for="strSurname">Email:</label>
                        <input type="text" name="email" class="form-control" v-model="fillItem.email" />
                        <span v-if="formErrorsUpdate['email']" class="error text-danger">@{{ formErrorsUpdate['email'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strSurname">Agent:</label>
                        <select  id='agent_id' name='agent_id' class="form-control "   v-model="fillItem.agent_id"  style="width: 100%;"  >
                               <option v-for="agent in agents" :value="agent.id"  >
                                    @{{ agent.name }}
                               </option>
                        </select>
                        <span v-if="formErrorsUpdate['agent_id']" class="error text-danger">@{{ formErrorsUpdate['agent_id'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strSurname">Role:</label>
                        <select  id='role_id' name='role_id' class="form-control "   v-model="fillItem.role_id"  style="width: 100%;"  >
                               <option v-for="role in roles" :value="role.id"  >
                                    @{{ role.name }}
                               </option>
                        </select>
                        <span v-if="formErrorsUpdate['role_id']" class="error text-danger">@{{ formErrorsUpdate['role_id'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strSurname">Password:</label>
                        <input type="password" name="password" class="form-control" v-model="fillItem.password" />
                        <span v-if="formErrorsUpdate['password']" class="error text-danger">@{{ formErrorsUpdate['password'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="strFirstName">Confirm Password:</label>
                        <input type="password" name="password_confirmation" class="form-control" v-model="fillItem.password_confirmation" />
                        <span v-if="formErrorsUpdate['password_confirmation']" class="error text-danger">@{{ formErrorsUpdate['password_confirmation'][0] }}</span>
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



    <script type="text/javascript" src="{!! asset('js/users.js') !!}"></script>

    @endsection
