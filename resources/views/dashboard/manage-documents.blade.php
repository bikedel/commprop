
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




    <div  v-cloak class="w3-container" id="manage-documents">


  <!-- Header -->
  <header class="w3-container" style="padding-top:42px">
    <h5><b><i class="fa fa-dashboard"></i> Legal Docs</b></h5><br>
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
                    <a href="{{ URL::route('exportDocuments') }}" class="btn btn-warning"> Export Documents</a>
                  @endif
                    <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#">
                      @{{pagination.total}} Records
                    </button>

                </div>

                <div class="pull-left">
                 @if ( Auth::user()->getRoleName()  == "Admin"  ||  Auth::user()->getRoleName()  == "System")
                    <button type="button" class="btn btn-success btn-md" @click.prevent="createForms">
                      New Document
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
                    <th width="200px">Action</th>
                    <th width="200px">Name</th>
                    <th width="200px">Description</th>
                     <th width="200px">File</th>



                </tr>
                <tr v-for="item in items">
                    <td >
                      @if ( Auth::user()->getRoleName()  == "Admin"  ||  Auth::user()->getRoleName()  == "System")
                      <button class="btn btn-primary btn-xs" @click.prevent="editItem(item)">Edit</button>
                        @if (  Auth::user()->getRoleName()  == "System")
                      <button class="btn btn-danger btn-xs" @click.prevent="deleteItem(item)">Delete</button>
                      @endif
                      @endif

                      <button class="btn btn-default btn-xs" @click.prevent="downloadItem(item.id)">Download</button>
                    </td>
                    <td>@{{ item.name }}</td>
                    <td>@{{ item.description}}</td>
                     <td>@{{ item.path}}</td>


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
             <form id="createDocument" method="POST" enctype="multipart/form-data" v-on:submit.prevent="createItem">
              <div class="modal-header">
                <button type="button" id="create-item-modal-header-button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">New Document</h4>
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
                        <label for="strSurname">Description:</label>
                        <input type="text" name="description" class="form-control" v-model="newItem.description" />
                        <span v-if="formErrors['description']" class="error text-danger">@{{ formErrors['description'][0] }}</span>
                    </div>

                    <div class="form-group">
                    <label for="Firstname">Document:</label>
                        <input type="file" id="file" class="btn btn-default " name="file"  style="width: 100%;" />
                        <span v-if="formErrors['file']" class="error text-danger">@{{ formErrors['file'][0] }}</span>
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
                <h4 class="modal-title" id="myModalLabel">Edit Document</h4>
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
                        <label for="strSurname">Description:</label>
                        <input type="text" name="description" class="form-control" v-model="fillItem.description" />
                        <span v-if="formErrorsUpdate['description']" class="error text-danger">@{{ formErrorsUpdate['description'][0] }}</span>
                    </div>
<!--
                    <div class="form-group">
                    <label for="Firstname">Document:</label>
                        <input type="file" id="document" class="btn btn-default " name="document"   style="width: 100%;"  />
                        <span v-if="formErrorsUpdate['document']" class="error text-danger">@{{ formErrorsUpdate['document'][0] }}</span>
                    </div>
-->

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



    <script type="text/javascript" src="{!! asset('js/documents.js') !!}"></script>

    @endsection
