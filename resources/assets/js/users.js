


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

  el: '#manage-users',

  data: {
   //offlinePath: '/laravel',
    offlinePath: '',
    items: [],
    roles: [],
    agents: [],
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
          'name':'',
          'email':'',
          'password':'',
          'agent_id':'',
          'role_id':'',
          'avatar':'',
          'password':'',
          'password_confirmation':'',

    },


    fillItem : { 
          'id':'',
          'name':'',
          'email':'',
          'password':'',
          'agent_id':'',
          'role_id':'',
          'avatar':'',
          'password':'',
          'password_confirmation':'',

    },

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
                axios.get(vm.offlinePath+'/commprop/public/vueusers?page='+page).then(function (response) {
                  vm.items = response.data.data.data;
                  vm.pagination =  response.data.pagination;
                  vm.roles = response.data.roles;
                  vm.agents = response.data.agents;


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
            this.$http.get('/commprop/public/vueusers?page='+page).then((response) => {
              this.$set('items', response.data.data.data);
              this.$set('pagination', response.data.pagination);
            //  this.$set('agents', response.data.agents);
            });
          // do search
           } else {
            this.$http.post('/commprop/public/searchvueusers/'+input).then((response) => {
              this.$set('items', response.data.data.data);
              this.$set('pagination', response.data.pagination);
           //   this.$set('agents', response.data.agents);
            });

           }
        },

        createItem: function(){

            var vm = this; 

            var input = vm.newItem;

            axios.post(vm.offlinePath+'/commprop/public/vueusers',input).then(function (response) {
          		  vm.changePage(vm.pagination.current_page);
          			vm.newItem = {
                      'name':'',
                      'email':'',
                      'password':'',
                      'agent_id':'',
                      'role_id':'',
                      'avatar':'',
                      'password':'',
                      'password_confirmation':'',
                };

          			$("#create-item").modal('hide');
                $(".modal-header button").click();

          			toastr.success('User Created Successfully.', 'Success Alert', {timeOut: 5000});

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
                      'name':'',
                      'email':'',
                      'password':'',
                      'agent_id':'',
                      'role_id':'',
                      'avatar':'',
                      'password':'',
                      'password_confirmation':'',
                };

                $("#create-item").modal('show');
      },




      deleteItem: function(item){


         // Vue.http.options.emulateJSON = true;

          var result = confirm("Are you sure you would like to delete this User?");
          if (result) {


              var vm = this; 

              axios.delete(vm.offlinePath+'/commprop/public/vueusers/'+item.id).then(function (response) {
                vm.changePage(vm.pagination.current_page);
                 toastr.success('User Deleted Successfully.', 'Success Alert', {timeOut: 5000});

              })
              .catch(function (error) {

                    status = error.response.status;
                  //   console.log(error.response.status);
                    
                    if (status < 500)
                    {
                          vm.formErrors = error.response.data;
                          toastr.warning("User not deleted.", 'Warning', {timeOut: 5000});
                    }else{
                          toastr.error("Please refresh the browser.", 'Session expired', {timeOut: 5000});
                    }
                   //   vm.$set(vm,'formErrors', error.response.data);


              });


          }

      },




      editItem: function(item){

          this.fillItem.id= item.id;
          this.fillItem.name= item.name;
          this.fillItem.email= item.email;
          this.fillItem.password= '';
          this.fillItem.password_confirmation= '';
          this.fillItem.agent_id= item.agent_id;
          this.fillItem.role_id= item.role_id;
          this.fillItem.avatar= item.avatar;


          $("#edit-item").modal('show');

          this.resetErrors();
      },


      updateItem: function(id){
     
       
                var vm = this; 

                var input = vm.fillItem;

            
                axios.post(this.offlinePath+'/commprop/public/updateuser/'+id,input).then(function (response) {

                      vm.changePage(vm.pagination.current_page);

                      this.fillItem = {
                        'id':'',
                        'name':'',
                        'email':'',
                        'password':'',
                        'agent_id':'',
                        'role_id':'',
                        'avatar':'',
                        'password':'',
                        'password_confirmation':'',  
                     };

                      $("#edit-item").modal('hide');
                      $(".modal-header button").click();

                       toastr.success('User Updated Successfully.', 'Success Alert', {timeOut: 5000});

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


    // get role name
    roleName: function (role_id) {
      //console.log("get saleTypeName");
          for(var i = 0; i < this.roles.length; i++){
              if (this.roles[i].id == role_id ){
                     //console.log("get saleTypeName "+ this.stypes[i].name );
                     return this.roles[i].name ;
              }  
          }
          return "error" ;  
   
     },

    // get agent name
    agentName: function (agent_id) {
      //console.log("get saleTypeName");
          for(var i = 0; i < this.agents.length; i++){
              if (this.agents[i].id == agent_id ){
                     //console.log("get saleTypeName "+ this.stypes[i].name );
                     return this.agents[i].name ;
              }  
          }
          return "" ;  
   
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