
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




//window.vueResource = require('vue-resource');

require('bootstrap-sass');

Vue.directive('sortable', {
  inserted: function (el, binding) {
    new sortable(el, binding.value || {})
  }
})


//Requires
var moment = require('moment');
//var moment = require('moment-timezone');
//Global Filters

Vue.filter('uppercase',function(value){
  return value.toUpperCase();
});

Vue.filter('dateFrom',function(value){
  //return moment(value).format('Do MMMM YYYY');
  //return moment.tz(value,'Africa/Johannesburg').fromNow();
 // moment().subtract(4, 'hours');
  return moment(value).add(2, 'hours').fromNow();

});

Vue.filter('dateNormal',function(value){
  return moment(value).format('Do MMMM YYYY');

});

Vue.filter('reverse', function(value) {
  // slice to make a copy of array, then reverse the copy
  return value.slice().reverse();
});

Vue.component('child', {
  props: ['text'],
  template: `<div><h1>{{ text }}</h1><div>`
});
//Vue.component('drop', require('./components/DropDown.vue'));
//Vue.component('Multiselect', VueMultiselect.Multiselect)


Vue.config.ignoredElements = ['blue','red'];

const vm = new Vue({

  el: '#manage-properties',

// this is our Model
data:  {


    // set to '/laravel' for local and online set to ''
    // for local use /laravel - online ''
    //offlinePath: '/laravel',
    offlinePath: '',
    seen: false,

    items: [],
    users: [],
    areas: [],
    suburbs: [],
    contacts: [],
    contacttypes: [],
    ptypes: [],
    stypes: [],
    statuses: [],

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
          'id': '',
          'erf': '',
          'title':'',
          'address':'',
          'description':'',
          'area_id': '',
          'image': [],
    },


    fillItem : { 
          'id':'',
          'erf': '',
          'title':'',
           'address':'',
          'description':'',
          'area_id': '',
          'image': [],
    },

 
    newUnit : {
         'property_type_id':'0',
         'sale_type_id':'0',
         'status_id':'0',
         'size':'',
         'price':'',
    },

    fillNote : { 
          'id':'',
          'erf':'',
          'unit_id':'',
          'note':[],
          'newnote': '',
    },


    fillOwner : { 
          'id':'',
          'erf':'',
          'unit_id':'',
          'owners':[],
          'company':'',
          'firstname':'',
          'lastname':'',
          'contact_type_id':'',
          'selectedContact':'',
          'tel': '',
          'cell': '',
          'email': '',
          'website': '',

    },

        s_erf: '',
        s_area: [],
        s_stype: [],
        s_ptype: [],
        s_status: [],
        s_minsize: '',
        s_maxsize: '',

        checked: '',

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
        },

 
    },



  mounted : function(){


         this.$nextTick(function () {
             //  console.log("starting properties.js");


              // get all select box data
              this.getVueSelects();
//console.log("loaded selects");

              // get all items
          		this.getVueItems(this.pagination.current_page);
              
            //  console.log("loaded main items");



              

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
               //  console.log("refresh picker");
                
                setTimeout(function() {
                  $('.selectpicker').selectpicker('refresh');
                }, 3000);

                setTimeout(function() {
                  $('.selectpicker').selectpicker('refresh');
                }, 5000);

          });

  },

  methods : {


        getVueItems: function(page){

          var vm = this; 

          axios.get(vm.offlinePath+'/commprop/public/vueproperties?page='+page).then(function (response) {
              //  axios.get(this.offlinePath+'/commprop/public/vuepropertiesSelects?page='+page).then(function (response) {

            vm.items = response.data.data.data;
            vm.pagination = response.data.pagination;

           // console.log("axios getVueItems completed");

          })
          .catch(function (error) {
        //    console.log(error);
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

/*
            this.$http.get(this.offlinePath+'/commprop/public/vueproperties?page='+page).then((response) => {
              this.$set(this,'items', response.data.data.data);
              this.$set(this,'pagination', response.data.pagination);

           //   console.log("getVueItems completed");


            });
*/

        },

        getVueSelects: function(){

            var vm = this; 

            axios.get(vm.offlinePath+'/commprop/public/vuepropertiesSelects').then(function (response) {
          
              vm.users = response.data.users;
              vm.areas =  response.data.areas;
              vm.suburbs = response.data.suburbs;
              vm.statuses = response.data.statuses;
              vm.stypes = response.data.stypes;
              vm.ptypes = response.data.ptypes;
              vm.contacttypes = response.data.contacttypes;
              vm.contacts = response.data.contacts;

 //$('.selectpicker').selectpicker('render');
             // console.log('axios getVueSelects completed');
              // console.log('refresh picker again');

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


        searchVueItems: function(page){
           //var input = this.search.s_area;
       //    console.log("searchVueItems page = " + page)

          //Vue.http.options.emulateJSON = true;

          // then in your code...
         let data = new FormData(document.getElementById('search'));
         // let data = new FormData();

  //        console.log("getting formdata for searchVueItems");

         // data.append('_token', this.token); // just the csrf token
          data.append('s_erf',this.s_erf);
          data.append('s_area',this.s_area);
          data.append('s_stype',this.s_stype);
          data.append('s_ptype',this.s_ptype);
          data.append('s_status',this.s_status);
          data.append('s_minsize',this.s_minsize);
          data.append('s_maxsize',this.s_maxsize);

          var input = data;

           /*
          // console.log("s_erf "+this.s_erf);
          // console.log("s_area "+this.s_area);
         //  console.log("s_stype "+this.s_stype);
          // console.log("s_ptype "+this.s_ptype);
          // console.log("s_minsize "+this.s_minsize);
         //  console.log("s_maxsize "+this.s_maxsize);
*/
            var vm = this; 
           // clear search
           if (!input) {
              axios.get(vm.offlinePath+'/commprop/public/vueproperties?page='+page).then(function (response) {
                vm.items = response.data.data.data;
                vm.pagination = response.data.pagination;

              })
              .catch(function (error) {
           //     console.log(error);
                    status = error.response.status;
             //        console.log(error.response.status);
                    
                    if (status == 422)
                    {
                          vm.formErrors = error.response.data;
                          toastr.warning("You have an error "+status, 'Warning', {timeOut: 5000});
                    }else{
                          toastr.error("Please refresh the browser.", 'Session expired', {timeOut: 5000});
                    }
              });
          // do search
           } else {

              axios.post(vm.offlinePath+'/commprop/public/searchvueproperties?page='+page,input).then(function (response) {
                vm.items = response.data.data.data;
                vm.pagination = response.data.pagination;
           //     console.log(vm.items[0].id);
           //     console.log(vm.pagination.total );
           //     console.log("axios earchtVueItems completed");

              })
              .catch(function (error) {
             //   console.log(error);
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

           }
            //console.log("searchVueItems completed "+this.items[1].id);

     //      console.log("searchVueItems completed");

        },

        getImage: function(e) {
            e.preventDefault();
            //  console.log('getImage success!');
            this.image = e.target.files[0];
        },


        createItem: function(){

          // somewhere in your Vue app.js file
          //Vue.http.options.emulateJSON = true;

          // then in your code...
          let data = new FormData(document.getElementById('createProp'));
       
          //data.append('image[]', this.image);



          var input = data;
      		 // var input = this.newItem;
            //alert(this.newItem.selected);



                $("#create-item-submit").attr('disabled', true);
                var vm = this; 

                axios.post(vm.offlinePath+'/commprop/public/vueproperties',input).then(function (response) {

                      vm.changePage(vm.pagination.current_page);

                      this.newItem = {
                        'id': '',
                        'erf': '',
                        'title':'',
                         'address':'',
                        'description':'',
                        'area_id': '',
                        'image': [],
                       };

                      vm.resetErrors();
                      $("#create-item-submit").attr('disabled', false);
                      $("#create-item").modal('hide');
                      $(".modal-header button").click();

                      toastr.success('Property Created Successfully.', 'Success Alert', {timeOut: 5000});

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
                   //   vm.$set(vm,'formErrors', error.response.data);
                   $("#create-item-submit").attr('disabled', false);

                });

      	},

      // add new owner
      createForms: function(){

                this.resetErrors();
                this.newItem = {
                'erf': '',
                'title':'', 
                'address':'',
                'description':'',
                'area_id':'',
                'image': '',
                               };
                 $("#myCreateModalLabel").text("Create Property");
                 $("#create-item").modal('show');
                               
                            
      },

      deleteItem: function(item){


         // Vue.http.options.emulateJSON = true;

          var result = confirm("Are you sure you would like to delete this Property?");
          if (result) {


              var vm = this; 

              axios.delete(vm.offlinePath+'/commprop/public/vueproperties/'+item.id).then(function (response) {
                vm.changePage(vm.pagination.current_page);
                 toastr.success('Property Deleted Successfully.', 'Success Alert', {timeOut: 5000});

              })
              .catch(function (error) {

                    status = error.response.status;
                  //   console.log(error.response.status);
                    
                    if (status < 500)
                    {
                          vm.formErrors = error.response.data;
                          toastr.warning("Property not deleted.", 'Warning', {timeOut: 5000});
                    }else{
                          toastr.error("Please refresh the browser.", 'Session expired', {timeOut: 5000});
                    }
                   //   vm.$set(vm,'formErrors', error.response.data);


              });


          }

      },


      deleteUnit: function(unit){

          var result = confirm("Are you sure you would like to delete this Unit?");
          if (result) {



              var vm = this; 

              axios.delete(vm.offlinePath+'/commprop/public/vuepropertiesDeleteUnit/'+unit.id).then(function (response) {
                vm.changePage(vm.pagination.current_page);
                toastr.success('Unit deleted successfully.', 'Success', {timeOut: 5000});

              })
              .catch(function (error) {

                    status = error.response.status;
                   //  console.log(error.response.status);
                    
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
          this.fillItem.id = item.id;
          this.fillItem.erf = item.erf;
          this.fillItem.title = item.title;
          this.fillItem.address = item.address;
          this.fillItem.description = item.description ;
          this.fillItem.area_id = item.area_id ;
          this.fillItem.image = item.images ;

          //console.log("rrr" + item.images);

          $("#edit-item").modal('show');

          this.resetErrors();
      },



       editNote: function(item,unit){
          this.fillNote.id = item.id;
          this.fillNote.erf = item.erf;

          if (unit){
             this.fillNote.unit_id = unit.id;
          } else {

            this.fillNote.unit_id = 0;
          }

          //console.log(unit.id);

          if (item.notes.length > 0){
             this.fillNote.note = item.notes;
          } else {
            this.fillNote.note =  [{description: 'No entries ...'}];
          
          }

          // reset scroll bat to the top
          this.$nextTick(() => {
      
              var container = this.$el.querySelector("#notetable");
              //console.log('edit scrollHeight  ' + container.scrollHeight);
              container.scrollTop = 0;
              container.scrollLeft = 0;

          })

          $("#edit-note").modal('show');

          this.resetErrors();

        },

        createNote: function(){


          // only add it test in newnote
          if (this.fillNote.newnote.length > 0 ){


              //  Vue.http.options.emulateJSON = true;

                // then in your code...
                let data = new FormData(document.getElementById('createNote'));

             
                var input = data;

                $("#edit-note-submit").attr('disabled', true);
                

                var vm = this; 

                axios.post(vm.offlinePath+'/commprop/public/vuepropertiesAddNote',input).then(function (response) {

                      vm.changePage(vm.pagination.current_page);

                      vm.fillNote = { 
                            'id':'',
                            'unit_id':'',
                            'note':[],
                            'newnote': '',
                      }
                      $("#edit-note-submit").attr('disabled', false);
                      vm.resetErrors();
                      $("#edit-note").modal('hide');
                      $(".modal-header button").click();

                      toastr.success('Note added successfully.', 'Success Alert', {timeOut: 5000});

                })
                .catch(function (error) {
                     status = error.response.status;
                   //  console.log(error.response.status);
                    
                    if (status == 422)
                    {
                          vm.formErrors = error.response.data;
                          toastr.warning("You have errors in the form.", 'Warning', {timeOut: 5000});
                    }else{
                          toastr.error("Please refresh the browser.", 'Session expired', {timeOut: 5000});
                    }

                     $("#edit-note-submit").attr('disabled', false);
                });



            } else {
                      $("#edit-note").modal('hide');
                      $(".modal-header button").click();
            }


        },


       editOwner: function(item,unit){
          this.fillOwner.id = item.id;
          this.fillOwner.erf = item.erf;
         

          // if unit is 0 then it applies to the main property otherwise it is a unit
          if (unit){
             this.fillOwner.unit_id = unit.id;
          } else {
            this.fillOwner.unit_id = 0;
          }

          if (item.owners.length > 0){
             this.fillOwner.owners = item.owners;
          } else {
            this.fillOwner.owners =  [{description: 'No owners ...'}];
          
          }

          // set these to null
          this.fillOwner.contact_type_id = 0;
          this.fillOwner.selectedContact = 0;

         

          // reset scroll bat to the top
          this.$nextTick(() => {
      
              var container = this.$el.querySelector("#ownertable");
              //console.log('edit scrollHeight  ' + container.scrollHeight);
              container.scrollTop = 0;
              container.scrollLeft = 0;
               this.checked = 'true';

          })


          $("#edit-owner").modal('show');

          this.resetErrors();
      },




    // get contact fields
    setContact: function (id) {
          //console.log("get suburbName");
          for(var i = 0; i < this.contacts.length; i++){
              if (this.contacts[i].id == id ){
                     //console.log("get suburbName "+ this.suburbs[i].name);
                     this.fillOwner.company = this.contacts[i].company;
                      this.fillOwner.firstname = this.contacts[i].firstname;
                      this.fillOwner.lastname = this.contacts[i].lastname;
                      this.fillOwner.tel = this.contacts[i].tel;
                      this.fillOwner.cell = this.contacts[i].cell;
                      this.fillOwner.email = this.contacts[i].email;
                      this.fillOwner.website = this.contacts[i].website;
                     
              }  
          }
         
   
     },

    getContactId: function (id) {
          //console.log("get suburbName");


          for(var i = 0; i < this.contacts.length; i++){
              if (this.contacts[i].id == id ){
                     //console.log("get suburbName "+ this.suburbs[i].name);
                     return i;
              }  
          }
         
   
     },

    createOwner: function(){

          // only add it test in newnote

            //    Vue.http.options.emulateJSON = true;

                // then in your code...
                let data = new FormData(document.getElementById('createOwner'));

                data.append('checked',this.checked);
                 data.append('selectedContact',this.fillOwner.selectedContact);

                

                var input = data;

                $("#edit-owner-submit").attr('disabled', true);
                
    
               var vm = this; 

                axios.post(vm.offlinePath+'/commprop/public/vuepropertiesAddOwner',input).then(function (response) {

                      vm.changePage(vm.pagination.current_page);


                      // get selects as the contacts has changed
                      vm.getVueSelects();
                      // refresh selectpicker
                      setTimeout(function() {
                        $('.selectpicker').selectpicker('refresh');
                      }, 5000);

                  vm.fillOwner = { 
                    'id':'',
                    'erf':'',
                    'unit_id':'',
                    'owners':[],
                    'company':'',
                    'firstname':'',
                    'lastname':'',
                    'contact_type_id':'',
                    'selectedContact':'',
                    'tel': '',
                    'cell': '',
                    'email': '',
                    'website': '',
                  }

                      $("#edit-owner-submit").attr('disabled', false);
                      vm.resetErrors();
                      $("#edit-owner").modal('hide');
                      $(".modal-header button").click();

                      toastr.success('Owner created successfully.', 'Success ', {timeOut: 5000});

                })
                .catch(function (error) {
                     status = error.response.status;
                   //  console.log(error.response.status);
                    
                    if (status == 422)
                    {
                          vm.formErrors = error.response.data;
                          toastr.warning("You have errors in the form.", 'Warning', {timeOut: 5000});
                    }else{
                          toastr.error("Please refresh the browser.", 'Session expired', {timeOut: 5000});
                    }
                    $("#edit-owner-submit").attr('disabled', false);
                    
                });


        },


      addUnit: function(item){

          this.newItem.id = item.id;
          this.newUnit.erf = item.erf;
          this.newUnit.property_type_id = "0";
          this.newUnit.sale_type_id = "0";

          $("#myCreateModalLabel").text("Add Unit");
          $("#create-unit").modal('show');

          this.resetErrors();
      },

        createUnit: function(){
          

          // then in your code...
          let data = new FormData(document.getElementById('createUnit'));

          data.append('property_id', this.newItem.id);
          data.append('property_type_id', this.newUnit.property_type_id);
          data.append('sale_type_id', this.newUnit.sale_type_id);
          data.append('status_id', this.newUnit.status_id);

          var input = data;

                $("#create-unit-submit").attr('disabled', true);
                
                var vm = this; 

                axios.post(vm.offlinePath+'/commprop/public/vuepropertiesAddunit',input).then(function (response) {

                      vm.changePage(vm.pagination.current_page);

                       vm.newUnit = { 
                         'property_type_id':'0',
                         'sale_type_id':'0',
                         'status_id':'0',
                         'size':'',
                         'price':'',
                      };
                       $("#create-unit-submit").attr('disabled', false);
                      vm.resetErrors();
                      $("#create-unit").modal('hide');
                      $(".modal-header button").click();

                      toastr.success('Unit added successfully.', 'Success Alert', {timeOut: 5000});

                })
                .catch(function (error) {
                     status = error.response.status;
                   //  console.log(error.response.status);
                    
                    if (status == 422)
                    {
                          vm.formErrors = error.response.data;
                          toastr.warning("You have errors in the form.", 'Warning', {timeOut: 5000});
                    }else{
                          toastr.error("Please refresh the browser.", 'Session expired', {timeOut: 5000});
                    }
                   //   vm.$set(vm,'formErrors', error.response.data);
                    $("#create-unit-submit").attr('disabled', false);
                    
                });


        },



      updateItem: function(id){

     
        //this.fillItem.selected = this.selectedAgent;
        var input = this.fillItem;

                var vm = this; 

                $("#edit-item-submit").attr('disabled', true);
                

                axios.put(this.offlinePath+'/commprop/public/vueproperties/'+id,input).then(function (response) {

                      vm.changePage(vm.pagination.current_page);

                      this.fillItem = {
                        'id':'',
                        'erf': '',
                        'title':'',
                        'address':'',
                        'description':'',
                        'area_id':'',
                        'image':'',
                    };

                      $("#edit-item-submit").attr('disabled', false);
                      vm.resetErrors();
                      $("#edit-item").modal('hide');
                      $(".modal-header button").click();

                       toastr.success('Property Updated Successfully.', 'Success Alert', {timeOut: 5000});

                })
                .catch(function (error) {
                     status = error.response.status;
                    // console.log(error.response.status);
                    
                    if (status == 422)
                    {
                          vm.formErrors = error.response.data;
                          toastr.warning("You have errors in the form.", 'Warning', {timeOut: 5000});
                    }else{
                          toastr.error("Please refresh the browser.", 'Session expired', {timeOut: 5000});
                    }
                    $("#edit-item-submit").attr('disabled', false);
                    
                });

      },


      createPDF: function(item){

                  window.location.href = this.offlinePath+'/commprop/public/createpdf/'+item.id ;


      },




      resetSearch: function() {
         // $('.form-group').each(function () { $(this).closest("span").removeClass('error text-danger'); });
         //  $('.form-group').each(function () { $(this).removeClass('form-control'); });
      //    $( ".text-danger" ).remove();


     // console.log('resetSearch started');
      $('.selectpicker').selectpicker('deselectAll');




        this.s_erf= '';
        this.s_area= [];
        this.s_stype= [];
        this.s_ptype= [];
        this.s_status= [];
        this.s_minsize= '';
        this.s_maxsize= '';
        this.searchVueItems();
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


      changePage: function (page) {
                //    console.log('changPage '+page);
          this.pagination.current_page = page;
          // check if any search items selected
          if( this.s_area  || this.s_ptype  || this.s_stype   || this.s_minsize || this.s_maxsize ){
/*
            console.log("s_area= " + this.s_area);
            console.log("s_stype= " + this.s_stype);
            console.log("s_ptype= " + this.s_ptype);
            console.log("s_minsize= " + this.s_minsize);
            console.log("s_maxsize= " + this.s_maxsize);
            console.log('changepage searchVueItems');
            */
            this.searchVueItems(page);
          }else{
         //   console.log('changepagegetVueItems');
            this.getVueItems(page);
          }



      }

  }

});