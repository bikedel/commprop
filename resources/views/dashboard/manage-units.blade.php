
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




    <div v-cloak class="w3-container"  id="manage-units">


  <!-- Header -->
  <header class="w3-container" style="padding-top:42px">
    <h5><b><i class="fa fa-dashboard"></i> Units</b></h5><br>
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
                    <a href="{{ URL::route('exportUnits') }}" class="btn btn-warning"> Export Units</a>
                    <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#">
                      @{{pagination.total}} Records
                    </button>

                </div>

                <div class="pull-left">
                    <button type="button" class="btn btn-success btn-md" @click.prevent="createForms">
                      New Unit
                    </button>
                </div>

            </div>

        </div>


        <!-- Item Listing -->
        <div class="w3-container" style="overflow-x:auto;">
            <br>
            <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
                <tr>
                    <th width="160px">Action</th>
                    <th width="130px">Property Id</th>
                    <th width="200px">Type</th>
                    <th width="130px">Status</th>
                    <th width="120px">Section</th>
                    <th width="120px">Deposit</th>
                    <th width="120px">Gross Rental</th>
                    <th width="130px">Net Rental</th>
                    <th width="130px">ops_costs</th>
                    <th width="120px">rates</th>
                    <th width="120px">Lease Start</th>
                    <th width="120px">Lease End</th>
                    <th width="130px">Size</th>
                    <th width="130px">Price</th>
                    <th width="120px">Brochure</th>
                    <th width="120px">Active Broker</th>
                    <th width="120px">Listing Broker</th>


                </tr>
                <tr v-for="item in items">
                    <td >
                    @if ( Auth::user()->getRoleName()  == "Admin"  ||  Auth::user()->getRoleName()  == "System")
                      <button class="btn btn-primary btn-xs" @click.prevent="editItem(item)">Edit</button>

                    @if ( Auth::user()->getRoleName()  == "System")
                      <button class="btn btn-danger btn-xs" @click.prevent="deleteItem(item)">Delete</button>
                    @endif

                    @endif
                    <!--
                      <button class="btn btn-default btn-xs" @click.prevent="viewProperties(item.id)">Properties</button>
                      -->
                    </td>
                    <td>@{{ item.property_id }}</td>
                    <td>@{{ propertyTypeName(item.property_type_id) }}  @{{ saleTypeName(item.sale_type_id) }}</td>
                    <td>@{{ statusName(item.status_id)}}</td>
                    <td>@{{ item.section}}</td>
                    <td>@{{ item.deposit | currency('R ', 2)}}</td>
                    <td>@{{ item.gross_rental | currency('R ', 2)}}</td>
                    <td>@{{ item.net_rental | currency('R ', 2)}}</td>
                    <td>@{{ item.ops_costs }}</td>
                    <td>@{{ item.rates }}</td>
                    <td>@{{ item.lease_start }}</td>
                    <td>@{{ item.lease_end }}</td>
                    <td>@{{ item.size | currency('', 0) }}</td>
                    <td>@{{ item.price | currency('R ', 2) }}</td>
                    <td>@{{ item.brochure_users }}</td>
                    <td>@{{ agentName(item.active_broker_id )}}</td>
                    <td>@{{ agentName(item.listing_broker_id )}}</td>


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
                <h4 class="modal-title" id="myModalLabel">New Unit</h4>
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

                    <div class="form-group" >
                        <label for="Surname">Property Id:</label>
                        <input type="text" name="id" class="form-control" v-model="newItem.id" />
                        <span v-if="formErrors['id']" class="error text-danger">@{{ formErrors['id'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Unit/Section:</label>
                        <input type="text" name="section" class="form-control" v-model="newItem.section" />
                        <span v-if="formErrors['section']" class="error text-danger">@{{ formErrors['section'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Property Type:</label>

                        <select  id='property_type_id' name='property_type_id' class="form-control "  v-model="newItem.property_type_id"  style="width: 100%;"  >
                           <option value="0" disabled  hidden>Please select property type...</option>
                               <option v-for="ptype in ptypes" :value="ptype.id"  >
                                    @{{ ptype.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['property_type_id']" class="error text-danger">@{{ formErrors['property_type_id'][0] }}</span>
                    </div>


                    <div class="form-group">
                        <label for="Firstname">Sale Type:</label>

                        <select  id='sale_type_id' name='sale_type_id' class="form-control "  v-model="newItem.sale_type_id"  style="width: 100%;"  >
                           <option value="0" disabled  hidden>Please select sale type...</option>
                               <option v-for="stype in stypes" :value="stype.id"  >
                                    @{{ stype.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['sale_type_id']" class="error text-danger">@{{ formErrors['sale_type_id'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Status:</label>

                        <select  id='status_id' name='status_id' class="form-control "  v-model="newItem.status_id"  style="width: 100%;"  >
                           <option value="0" disabled  hidden>Please select status...</option>
                               <option v-for="status in statuses" :value="status.id"  >
                                    @{{ status.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['status_id']" class="error text-danger">@{{ formErrors['status_id'][0] }}</span>
                    </div>


                    <div class="form-group" >
                        <label for="Surname">Size:</label>
                        <input type="text" name="size" class="form-control" v-model="newItem.size" />
                        <span v-if="formErrors['size']" class="error text-danger">@{{ formErrors['size'][0] }}</span>
                    </div>


                    <div class="form-group" >
                        <label for="Surname">Price:</label>
                        <input type="text" name="price" class="form-control" v-model="newItem.price" />
                        <span v-if="formErrors['price']" class="error text-danger">@{{ formErrors['price'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Deposit:</label>
                        <input type="text" name="deposit" class="form-control" v-model="newItem.deposit" />
                        <span v-if="formErrors['deposit']" class="error text-danger">@{{ formErrors['deposit'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Gross Rental:</label>
                        <input type="text" name="gross_rental" class="form-control" v-model="newItem.gross_rental" />
                        <span v-if="formErrors['gross_rental']" class="error text-danger">@{{ formErrors['gross_rental'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Net Rental:</label>
                        <input type="text" name="net_rental" class="form-control" v-model="newItem.net_rental" />
                        <span v-if="formErrors['net_rental']" class="error text-danger">@{{ formErrors['net_rental'][0] }}</span>
                    </div>

                   <div class="form-group" >
                        <label for="Surname">Ops Costs:</label>
                        <input type="text" name="ops_costs" class="form-control" v-model="newItem.ops_costs" />
                        <span v-if="formErrors['ops_costs']" class="error text-danger">@{{ formErrors['ops_costs'][0] }}</span>
                    </div>

                   <div class="form-group" >
                        <label for="Surname">Rates:</label>
                        <input type="text" name="rates" class="form-control" v-model="newItem.rates" />
                        <span v-if="formErrors['rates']" class="error text-danger">@{{ formErrors['rates'][0] }}</span>
                    </div>

                   <div class="form-group" >
                        <label for="Surname">Investment Yield:</label>
                        <input type="text" name="investment_yield" class="form-control" v-model="newItem.investment_yield" />
                        <span v-if="formErrors['investment_yield']" class="error text-danger">@{{ formErrors['investment_yield'][0] }}</span>
                    </div>


                    <div class="form-group" >
                        <label for="Surname">Lease Start:</label>
                        <input type="date" name="lease_start" class="form-control" v-model="newItem.lease_start" />
                        <span v-if="formErrors['lease_start']" class="error text-danger">@{{ formErrors['lease_start'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Lease End:</label>
                        <input type="date" name="lease_end" class="form-control" v-model="newItem.lease_end" />
                        <span v-if="formErrors['lease_end']" class="error text-danger">@{{ formErrors['lease_end'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Active Agent:</label>

                        <select  id='agent_id' name='active_broker_id' class="form-control "  v-model="newItem.active_broker_id" style="width: 100%;"  >
                           <option value="0" disabled  hidden>Please select agent...</option>
                               <option v-for="agent in agents" :value="agent.id"  >
                                    @{{ agent.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['active_broker_id']" class="error text-danger">@{{ formErrors['abroker'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Listing Agent:</label>

                        <select  id='agent_id' name='listing_broker_id' class="form-control "  v-model="newItem.listing_broker_id" style="width: 100%;"  >
                           <option value="0" disabled  hidden>Please select agent...</option>
                               <option v-for="agent in agents" :value="agent.id"  >
                                    @{{ agent.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['listing_broker_id']" class="error text-danger">@{{ formErrors['lbroker'][0] }}</span>
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

                    <div class="form-group" hidden>
                        <label for="Surname">Id:</label>
                        <input type="text" name="id" class="form-control" v-model="fillItem.id" readonly/>
                        <span v-if="formErrors['id']" class="error text-danger">@{{ formErrors['id'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Unit/Section:</label>
                        <input type="text" name="section" class="form-control" v-model="fillItem.section" />
                        <span v-if="formErrors['section']" class="error text-danger">@{{ formErrors['section'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Property Type:</label>

                        <select  id='property_type_id' name='property_type_id' class="form-control "  v-model="fillItem.property_type_id"  style="width: 100%;"  >
                           <option value="0" disabled  hidden>Please select property type...</option>
                               <option v-for="ptype in ptypes" :value="ptype.id"  >
                                    @{{ ptype.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['property_type_id']" class="error text-danger">@{{ formErrors['property_type_id'][0] }}</span>
                    </div>


                    <div class="form-group">
                        <label for="Firstname">Sale Type:</label>

                        <select  id='sale_type_id' name='sale_type_id' class="form-control "  v-model="fillItem.sale_type_id"  style="width: 100%;"  >
                           <option value="0" disabled  hidden>Please select sale type...</option>
                               <option v-for="stype in stypes" :value="stype.id"  >
                                    @{{ stype.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['sale_type_id']" class="error text-danger">@{{ formErrors['sale_type_id'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Status:</label>

                        <select  id='status_id' name='status_id' class="form-control "  v-model="fillItem.status_id"  style="width: 100%;"  >
                           <option value="0" disabled  hidden>Please select status...</option>
                               <option v-for="status in statuses" :value="status.id"  >
                                    @{{ status.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['status_id']" class="error text-danger">@{{ formErrors['status_id'][0] }}</span>
                    </div>


                    <div class="form-group" >
                        <label for="Surname">Size:</label>
                        <input type="text" name="size" class="form-control" v-model="fillItem.size" />
                        <span v-if="formErrors['size']" class="error text-danger">@{{ formErrors['size'][0] }}</span>
                    </div>


                    <div class="form-group" >
                        <label for="Surname">Price:</label>
                        <input type="text" name="price" class="form-control" v-model="fillItem.price" />
                        <span v-if="formErrors['price']" class="error text-danger">@{{ formErrors['price'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Deposit:</label>
                        <input type="text" name="deposit" class="form-control" v-model="fillItem.deposit" />
                        <span v-if="formErrors['deposit']" class="error text-danger">@{{ formErrors['deposit'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Gross Rental:</label>
                        <input type="text" name="gross_rental" class="form-control" v-model="fillItem.gross_rental" />
                        <span v-if="formErrors['gross_rental']" class="error text-danger">@{{ formErrors['gross_rental'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Net Rental:</label>
                        <input type="text" name="net_rental" class="form-control" v-model="fillItem.net_rental" />
                        <span v-if="formErrors['net_rental']" class="error text-danger">@{{ formErrors['net_rental'][0] }}</span>
                    </div>

                   <div class="form-group" >
                        <label for="Surname">Ops Costs:</label>
                        <input type="text" name="ops_costs" class="form-control" v-model="fillItem.ops_costs" />
                        <span v-if="formErrors['ops_costs']" class="error text-danger">@{{ formErrors['ops_costs'][0] }}</span>
                    </div>

                   <div class="form-group" >
                        <label for="Surname">Rates:</label>
                        <input type="text" name="rates" class="form-control" v-model="fillItem.rates" />
                        <span v-if="formErrors['rates']" class="error text-danger">@{{ formErrors['rates'][0] }}</span>
                    </div>

                   <div class="form-group" >
                        <label for="Surname">Investment Yield:</label>
                        <input type="text" name="investment_yield" class="form-control" v-model="fillItem.investment_yield" />
                        <span v-if="formErrors['investment_yield']" class="error text-danger">@{{ formErrors['investment_yield'][0] }}</span>
                    </div>


                    <div class="form-group" >
                        <label for="Surname">Lease Start:</label>
                        <input type="date" name="lease_start" class="form-control" v-model="fillItem.lease_start" />
                        <span v-if="formErrors['lease_start']" class="error text-danger">@{{ formErrors['lease_start'][0] }}</span>
                    </div>

                    <div class="form-group" >
                        <label for="Surname">Lease End:</label>
                        <input type="date" name="lease_end" class="form-control" v-model="fillItem.lease_end" />
                        <span v-if="formErrors['lease_end']" class="error text-danger">@{{ formErrors['lease_end'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Active Agent:</label>

                        <select  id='agent_id' name='active_broker_id' class="form-control "  v-model="fillItem.active_broker_id" style="width: 100%;"  >
                           <option value="0" disabled  hidden>Please select agent...</option>
                               <option v-for="agent in agents" :value="agent.id"  >
                                    @{{ agent.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['active_broker_id']" class="error text-danger">@{{ formErrors['abroker'][0] }}</span>
                    </div>

                    <div class="form-group">
                        <label for="Firstname">Listing Agent:</label>

                        <select  id='agent_id' name='listing_broker_id' class="form-control "  v-model="fillItem.listing_broker_id" style="width: 100%;"  >
                           <option value="0" disabled  hidden>Please select agent...</option>
                               <option v-for="agent in agents" :value="agent.id"  >
                                    @{{ agent.name }}
                               </option>
                        </select>
                        <span v-if="formErrors['listing_broker_id']" class="error text-danger">@{{ formErrors['lbroker'][0] }}</span>
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



    <script type="text/javascript" src="{!! asset('js/units.js') !!}"></script>

    @endsection
