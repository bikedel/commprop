


window._ = require('lodash');

window.Vue = require('vue');

//window.vueResource = require('vue-resource');

window.sortable = require('sortablejs');

window.Vue2Filters = require('vue2-filters');

window.$ = window.jQuery = require('jquery');

window.toastr = require('toastr');
window.bootstrapSelect = require('bootstrap-select');

window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};


require('bootstrap-sass');


const vm = new Vue({

  el: '#manage-units',

  data: {
    offlinePath: '/laravel',
    //offlinePath: '',

    user: '',
    agent: 0,

    items: [],

    agents: [],
    items: [],
    users: [],
    areas: [],
    grades: [],
    suburbs: [],
    contacts: [],
    contacttypes: [],
    ptypes: [],
    stypes: [],
    statuses: [],
    brochures: [],

    pagination: {
        total: 0, 
        per_page: 2,
        from: 1, 
        to: 0,
        current_page: 1
      },
    offset: 4,
    formErrors:{},
    formErrorsUpdate:{},
    newItem : { 
          'property_id':'',
          'property_type_id':'',
          'sale_type_id':'',
          'status_id':'',
          'section':'',
          'investment_yield':'',
          'deposit':'',
          'gross_rental':'',
          'net_rental':'',
          'ops_costs':'',
          'rates':'',
          'availability':'',
          'lease_start':'',
          'lease_end':'',
           'size':'',
          'price':'',
          'brochure_users':'',
          'active_broker_id':'',
          'listing_broker_id':'',
    },


    fillItem : { 
          'id':'',
          'property_id':'',
          'property_type_id':'',
          'sale_type_id':'',
          'status_id':'',
          'section':'',
          'investment_yield':'',
          'deposit':'',
          'gross_rental':'',
          'net_rental':'',
          'ops_costs':'',
          'rates':'',
          'availability':'',
          'lease_start':'',
          'lease_end':'',
           'size':'',
          'price':'',
          'brochure_users':'',
          'active_broker_id':'',
          'listing_broker_id':'',

    },

    properties: [],

      search : {'string':''},


  },



  computed: {
        isActived: function () {
            return this.pagination.current_page;
        },
        pagesNumber: function () {
            if (!this.pagination.to) {
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },

  mounted : function(){

         this.$nextTick(function () {

              // get all items
          		this.getVueItems(this.pagination.current_page);

              this.getVueSelects();
              
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
          });


  },

  methods : {




        getVueItems: function(page){
           var vm = this; 
           // this.$http.get(this.offlinePath+'/commprop/public/vueusers?page='+page).then((response) => {
                axios.get(vm.offlinePath+'/commprop/public/vueunits?page='+page).then(function (response) {
                  vm.items = response.data.data.data;
                  vm.pagination =  response.data.pagination;

                })
                .catch(function (error) {

                           status = error.response.status;
                       //    console.log(error.response.status);
                          
                          if (status == 422)
                          {
                                vm.formErrors = error.response.data;
                                toastr.warning("You have an error "+status, 'Warning', {timeOut: 5000});
                          }else{
                                toastr.error("Please refresh the browser.", 'Session expired', {timeOut: 5000});
                          }
                });
        },




        searchVueItems: function(page){
           var input = this.search.string;

           // clear search
           if (!input) {
            this.$http.get('/commprop/public/vueunits?page='+page).then((response) => {
              this.$set('items', response.data.data.data);
              this.$set('pagination', response.data.pagination);
            //  this.$set('agents', response.data.agents);
            });
          // do search
           } else {
            this.$http.post('/commprop/public/searchvueunits/'+input).then((response) => {
              this.$set('items', response.data.data.data);
              this.$set('pagination', response.data.pagination);
           //   this.$set('agents', response.data.agents);
            });

           }
        },

        getVueSelects: function(){

            var vm = this; 

            axios.get(vm.offlinePath+'/commprop/public/vuepropertiesSelects').then(function (response) {
          
              vm.agents = response.data.agents;
              vm.users = response.data.users;
              vm.areas =  response.data.areas;
              vm.suburbs = response.data.suburbs;
              vm.statuses = response.data.statuses;
              vm.stypes = response.data.stypes;
              vm.ptypes = response.data.ptypes;
              vm.contacttypes = response.data.contacttypes;
              vm.contacts = response.data.contacts;
              vm.user = response.data.user;
              vm.grades = response.data.grades;

              // if the agent is a user
              //vm.setAgent(vm.user);

              })
             .catch(function (error) {

                     status = error.response.status;
                   //  console.log(error.response.status);
                    
                    if (status == 422)
                    {
                          vm.formErrors = error.response.data;
                          toastr.warning("You have an error "+status, 'Warning', {timeOut: 5000});
                    }else{
                          toastr.error("Please refresh the browser.", 'Session expired', {timeOut: 5000});
                    }
             });
        },



        createItem: function(){

            var vm = this; 

            var input = vm.newItem;

            axios.post(vm.offlinePath+'/commprop/public/vueunits',input).then(function (response) {
          		  vm.changePage(vm.pagination.current_page);
          			vm.newItem = {
                    'property_id':'',
                    'property_type_id':'',
                    'sale_type_id':'',
                    'status_id':'',
                    'section':'',
                    'investment_yield':'',
                    'deposit':'',
                    'gross_rental':'',
                    'net_rental':'',
                    'ops_costs':'',
                    'rates':'',
                    'availability':'',
                    'lease_start':'',
                    'lease_end':'',
                     'size':'',
                    'price':'',
                    'brochure_users':'',
                    'active_broker_id':'',
                    'listing_broker_id':'',
                };

          			$("#create-item").modal('hide');
                $(".modal-header button").click();

          			toastr.success('Unit Created Successfully.', 'Success Alert', {timeOut: 5000});

                })
                .catch(function (error) {
                    status = error.response.status;
                  //   console.log(error.response.status);
                    
                    if (status < 500)
                    {
                          vm.formErrors = error.response.data;
                          toastr.warning("Errors in form.", 'Warning', {timeOut: 5000});
                    }else{
                          toastr.error("Please refresh the browser.", 'Session expired', {timeOut: 5000});
                    }

                });


      	},



      createForms: function(){

                this.resetErrors();
                this.newItem = {
                      'property_id':'',
                      'property_type_id':'',
                      'sale_type_id':'',
                      'status_id':'',
                      'section':'',
                      'investment_yield':'',
                      'deposit':'',
                      'gross_rental':'',
                      'net_rental':'',
                      'ops_costs':'',
                      'rates':'',
                      'availability':'',
                      'lease_start':'',
                      'lease_end':'',
                       'size':'',
                      'price':'',
                      'brochure_users':'',
                      'active_broker_id':'',
                      'listing_broker_id':'',
                };

                $("#create-item").modal('show');
      },




      deleteItem: function(item){


         // Vue.http.options.emulateJSON = true;

          var result = confirm("Are you sure you would like to delete this Unit?");
          if (result) {


              var vm = this; 

              axios.delete(vm.offlinePath+'/commprop/public/vueunits/'+item.id).then(function (response) {
                vm.changePage(vm.pagination.current_page);
                 toastr.success('Unit Deleted Successfully.', 'Success Alert', {timeOut: 5000});

              })
              .catch(function (error) {

                    status = error.response.status;
                  //   console.log(error.response.status);
                    
                    if (status < 500)
                    {
                          vm.formErrors = error.response.data;
                          toastr.warning("Unit not deleted.", 'Warning', {timeOut: 5000});
                    }else{
                          toastr.error("Please refresh the browser.", 'Session expired', {timeOut: 5000});
                    }
                   //   vm.$set(vm,'formErrors', error.response.data);


              });


          }

      },




      editItem: function(item){


           this.fillItem.id= item.id;
            this.fillItem.property_id= item.property_id;
            this.fillItem.property_type_id= item.property_type_id;
            this.fillItem.sale_type_id= item.sale_type_id;
            this.fillItem.status_id= item.status_id;
            this.fillItem.section= item.section;
            this.fillItem.investment_yield= item.investment_yield;
            this.fillItem.deposit= item.deposit;
            this.fillItem.gross_rental= item.gross_rental;
            this.fillItem.net_rental= item.net_rental;
            this.fillItem.ops_costs= item.ops_costs;
            this.fillItem.rates= item.rates;
            this.fillItem.availability= item.availability;
            this.fillItem.lease_start= item.lease_start;
            this.fillItem.lease_end= item.lease_end;
            this.fillItem.size= item.size;
            this.fillItem.price= item.price;
            this.fillItem.brochure_users= item.brochure_users;
            this.fillItem.active_broker_id= item.active_broker_id;
            this.fillItem.listing_broker_id= item.listing_broker_id;

          $("#edit-item").modal('show');

          this.resetErrors();
      },


      updateItem: function(id){
     
       
                var vm = this; 

                var input = vm.fillItem;

            
                axios.post(this.offlinePath+'/commprop/public/updateunit/'+id,input).then(function (response) {

                      vm.changePage(vm.pagination.current_page);

                      this.fillItem = {
                        'property_id':'',
                        'property_type_id':'',
                        'sale_type_id':'',
                        'status_id':'',
                        'section':'',
                        'investment_yield':'',
                        'deposit':'',
                        'gross_rental':'',
                        'net_rental':'',
                        'ops_costs':'',
                        'rates':'',
                        'availability':'',
                        'lease_start':'',
                        'lease_end':'',
                         'size':'',
                        'price':'',
                        'brochure_users':'',
                        'active_broker_id':'',
                        'listing_broker_id':'',
                     };

                      $("#edit-item").modal('hide');
                      $(".modal-header button").click();

                       toastr.success('Contact Updated Successfully.', 'Success Alert', {timeOut: 5000});

                })
                .catch(function (error) {
                     status = error.response.status;
                    // console.log(error.response.status);
                    
                    if (status == 422)
                    {
                          vm.formErrorsUpdate = error.response.data;
                          toastr.warning("You have errors in the form.", 'Warning', {timeOut: 5000});
                    }else{
                          toastr.error("Please refresh the browser.", 'Session expired', {timeOut: 5000});
                    }
                    
                });

      },




      viewProperties: function(id){

                  
               // vm.properties = [];
                var vm = this; 
                vm.fillItem.id= id;
                var input = vm.fillItem;

            
                axios.get(vm.offlinePath+'/commprop/public/contactProp'+id,input).then(function (response) {

                     vm.properties = response.data.data;
                     vm.contacttypes = response.data.contacttypes;


                    $("#view-properties").modal('show');

                     //  toastr.success('Contact Updated Successfully.', 'Success Alert', {timeOut: 5000});

                })
                .catch(function (error) {
                     status = error.response.status;
                    // console.log(error.response.status);
                    
                    if (status == 422)
                    {
                          vm.formErrorsUpdate = error.response.data;
                          toastr.warning("You have errors in the form.", 'Warning', {timeOut: 5000});
                    }else{
                          toastr.error("Please refresh the browser.", 'Session expired', {timeOut: 5000});
                    }
                    
                });

      },

    // get user name
    userName: function (user_id) {
          //console.log("get suburbName");
          for(var i = 0; i < this.users.length; i++){
              if (this.users[i].id == user_id ){
                     //console.log("get suburbName "+ this.suburbs[i].name);
                     return this.users[i].name ;
              }  
          }
          return "error" ;  
   
     },

    // get user name
    agentName: function (agent_id) {
          //console.log("get suburbName");
          for(var i = 0; i < this.agents.length; i++){
              if (this.agents[i].id == agent_id ){
                     //console.log("get suburbName "+ this.suburbs[i].name);
                     return this.agents[i].name ;
              }  
          }
          return "" ;  
   
     },

    // get suburb name
    suburbName: function (suburb_id) {
          //console.log("get suburbName");
          for(var i = 0; i < this.suburbs.length; i++){
              if (this.suburbs[i].id == suburb_id ){
                     //console.log("get suburbName "+ this.suburbs[i].name);
                     return this.suburbs[i].name ;
              }  
          }
          return "error" ;  
   
     },


    // get ptype name
    typeName: function (type) {
      //console.log("get propertyTypeName");
        if (type == 0){
                return 'Freehold' ;
         }
        if (type == 1){
                return 'Sectional Title' ;
         }
 
          return "error" ;  
   
     },

    // get ptype name
    propertyTypeName: function (property_type_id) {
      //console.log("get propertyTypeName");
          for(var i = 0; i < this.ptypes.length; i++){
              if (this.ptypes[i].id == property_type_id ){
                     //console.log("get propertyTypeName "+this.ptypes[i].name);
                     return this.ptypes[i].name ;
              }  
          }
          return "error" ;  
   
     },

    // get stype name
    saleTypeName: function (sale_type_id) {
      //console.log("get saleTypeName");
          for(var i = 0; i < this.stypes.length; i++){
              if (this.stypes[i].id == sale_type_id ){
                     //console.log("get saleTypeName "+ this.stypes[i].name );
                     return this.stypes[i].name ;
              }  
          }
          return "error" ;  
   
     },

    // get status name
    statusName: function (status_id) {
      //console.log("get saleTypeName");
          for(var i = 0; i < this.statuses.length; i++){
              if (this.statuses[i].id == status_id ){
                     //console.log("get saleTypeName "+ this.stypes[i].name );
                     return this.statuses[i].name ;
              }  
          }
          return "error" ;  
   
     },

    // get status name
    gradeName: function (grade_id) {
      //console.log("get saleTypeName");
          for(var i = 0; i < this.grades.length; i++){
              if (this.grades[i].id == grade_id ){
                     //console.log("get saleTypeName "+ this.stypes[i].name );
                     return this.grades[i].name ;
              }  
          }
          return "error" ;  
   
     },


      resetErrors: function() {
         // $('.form-group').each(function () { $(this).closest("span").removeClass('error text-danger'); });
         //  $('.form-group').each(function () { $(this).removeClass('form-control'); });
      //    $( ".text-danger" ).remove();

           this.formErrorsUpdate = "";
           this.formErrors = "";
      },




      log: function(str) {
        alert("change log");
        $('#log').append(str + "<br>");
      },

      changePage: function (page) {
          this.pagination.current_page = page;
          this.getVueItems(page);
      }

  }

});