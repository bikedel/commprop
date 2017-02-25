Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

Vue.http.interceptors.push(function (request, next) {
    request.headers['X-CSRF-TOKEN'] = Laravel.csrfToken;
    next();
});


Vue.filter('uppercase',function(value){
  return value.toUpperCase();
});

Vue.filter('dateFrom',function(value){
  //return moment(value).format('Do MMMM YYYY');
  return moment(value).fromNow();
});

Vue.filter('dateNormal',function(value){
  return moment(value).format('Do MMMM YYYY');

});
//Vue.component('drop', require('./components/DropDown.vue'));
//Vue.component('Multiselect', VueMultiselect.Multiselect)
var moment = require('moment');


var vm = new Vue({

  el: '#manage-properties',

// this is our Model
data:  {

    // set to '/laravel' for local and online set to ''
    //offlinePath: '/laravel',
    offlinePath: '',
    seen: false,

    items: [],
    users: [],
    areas: [],
    ptypes: [],
    stypes: [],

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
          'description':'',
          'area_id': '',
          'image': [],
    },


    fillItem : { 
          'id':'',
          'erf': '',
          'title':'',
          'description':'',
          'area_id': '',
          'image': [],
    },

 
    newUnit : {
         'property_type_id':'',
         'sale_type_id':'',
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
          'contact':'',
          'tel': '',
          'cell': '',
          'email': '',

    },
        s_area: '',
        s_stype: '',
        s_ptype: '',
        s_minsize: '',
        s_maxsize: '',


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



  ready : function(){



      // get all items
  		this.getVueItems(this.pagination.current_page);
      

      // get all select box data
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


  },

  methods : {

 
        moment: {},

        getVueItems: function(page){
            this.$http.get(this.offlinePath+'/commprop/public/vueproperties?page='+page).then((response) => {
              this.$set('items', response.data.data.data);
              this.$set('pagination', response.data.pagination);

            });


        },

        getVueSelects: function(){
            this.$http.get(this.offlinePath+'/commprop/public/vuepropertiesSelects').then((response) => {
              this.$set('users', response.data.users);
              this.$set('areas', response.data.areas);
              this.$set('stypes', response.data.stypes);
              this.$set('ptypes', response.data.ptypes);
            });
        },


        searchVueItems: function(page){
           //var input = this.search.s_area;


          Vue.http.options.emulateJSON = true;

          // then in your code...
          let data = new FormData(document.getElementById('search'));
       
          data.append('s_area',this.s_area);
          data.append('s_stype',this.s_stype);
          data.append('s_ptype',this.s_ptype);
          data.append('s_minsize',this.s_minsize);
          data.append('s_maxsize',this.s_maxsize);

          var input = data;


           // clear search
           if (!input) {
            this.$http.get(this.offlinePath+'/commprop/public/vueproperties?page='+page).then((response) => {
              this.$set('items', response.data.data.data);
              this.$set('pagination', response.data.pagination);
            //  this.$set('agents', response.data.agents);
            });
          // do search
           } else {
            this.$http.post(this.offlinePath+'/commprop/public/searchvueproperties/'+input+'?page='+page,input).then((response) => {
              this.$set('items', response.data.data.data);
              this.$set('pagination', response.data.pagination);
           //   this.$set('agents', response.data.agents);
            });

           }
        },

        getImage: function(e) {
            e.preventDefault();
              console.log('success!');
            this.image = e.target.files[0];
        },


        createItem: function(){

          // somewhere in your Vue app.js file
          Vue.http.options.emulateJSON = true;

          // then in your code...
          let data = new FormData(document.getElementById('createProp'));
       
          //data.append('image[]', this.image);



          var input = data;
      		 // var input = this.newItem;
            //alert(this.newItem.selected);
      		  this.$http.post(this.offlinePath+'/commprop/public/vueproperties',input).then((response) => {
          		  this.changePage(this.pagination.current_page);
          			this.newItem = {
                  'id': '',
                  'erf': '',
                  'title':'',
                  'description':'',
                  'area_id': '',
                  'image': [],
                               };
                this.resetErrors();
          			$("#create-item").modal('hide');
                $(".modal-header button").click();

          			toastr.success('Property Created Successfully.', 'Success Alert', {timeOut: 5000});
          		}, (response) => {
          			this.formErrors = response.data;
                toastr.error('Error in form.', 'Warning', {timeOut: 5000});
        	    });
      	},

      // add new owner
      createForms: function(){

                this.resetErrors();
                this.newItem = {
                'erf': '',
                'title':'',
                'description':'',
                'area_id':'',
                'image': '',
                               };
                 $("#myCreateModalLabel").text("Create Property");
                 $("#create-item").modal('show');
                               
                            
      },

      deleteItem: function(item){

          var result = confirm("Are you sure you would like to delete this Property?");
          if (result) {
                  this.$http.delete(this.offlinePath+'/commprop/public/vueproperties/'+item.id).then((response) => {
                      this.changePage(this.pagination.current_page);
                      toastr.success('Property Deleted Successfully.', 'Success Alert', {timeOut: 5000});
                  });
          }

      },


      deleteUnit: function(unit){

          var result = confirm("Are you sure you would like to delete this Unit?");
          if (result) {
                  this.$http.delete(this.offlinePath+'/commprop/public/vuepropertiesDeleteUnit/'+unit.id).then((response) => {
                      this.changePage(this.pagination.current_page);
                      toastr.success('Unit deleted successfully.', 'Success Alert', {timeOut: 5000});
                  });
          }

      },

      editItem: function(item){
          this.fillItem.id = item.id;
          this.fillItem.erf = item.erf;
          this.fillItem.title = item.title;
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
              console.log('edit scrollHeight  ' + container.scrollHeight);
              container.scrollTop = 0;

          })

          $("#edit-note").modal('show');

          this.resetErrors();
      },

        createNote: function(){


          // only add it test in newnote
          if (this.fillNote.newnote.length > 0 ){
                Vue.http.options.emulateJSON = true;

                // then in your code...
                let data = new FormData(document.getElementById('createNote'));

             
                var input = data;
    
                  this.$http.post(this.offlinePath+'/commprop/public/vuepropertiesAddNote',input).then((response) => {
                      this.changePage(this.pagination.current_page);

                  this.fillNote = { 
                        'id':'',
                        'unit_id':'',
                        'note':[],
                        'newnote': '',
                  }

                      this.resetErrors();
                      $("#edit-note").modal('hide');
                      $(".modal-header button").click();

                      toastr.success('Note added successfully.', 'Success Alert', {timeOut: 5000});
                    }, (response) => {
                      this.formErrors = response.data;
                      toastr.error('Error in form.', 'Warning', {timeOut: 5000});
                    });

            } else {
                      $("#edit-note").modal('hide');
                      $(".modal-header button").click();
            }


        },


       editOwner: function(item,unit){
          this.fillOwner.id = item.id;
          this.fillOwner.erf = item.erf;
         
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



          $("#edit-owner").modal('show');

          this.resetErrors();
      },

    createOwner: function(){

          // only add it test in newnote

                Vue.http.options.emulateJSON = true;

                // then in your code...
                let data = new FormData(document.getElementById('createOwner'));

             
                var input = data;
    
                  this.$http.post(this.offlinePath+'/commprop/public/vuepropertiesAddOwner',input).then((response) => {
                      this.changePage(this.pagination.current_page);

                  this.fillOwner = { 
                        'id':'',
                        'erf':'',
                        'unit_id':'',
                        'owners':[],
                        'contact':'',
                        'tel': '',
                        'cell': '',
                        'email': '',
                  }

                      this.resetErrors();
                      $("#edit-owner").modal('hide');
                      $(".modal-header button").click();

                      toastr.success('Owner created successfully.', 'Success Alert', {timeOut: 5000});
                    }, (response) => {
                      this.formErrors = response.data;
                      toastr.error('Error in form.', 'Warning', {timeOut: 5000});
                    });


        },


      addUnit: function(item){
          //this.fillItem.id = item.id;
          this.newItem.id = item.id;
          this.newItem.title = item.title;

          $("#myCreateModalLabel").text("Add Unit");
          $("#create-unit").modal('show');

          this.resetErrors();
      },

        createUnit: function(){
          Vue.http.options.emulateJSON = true;

          // then in your code...
          let data = new FormData(document.getElementById('createUnit'));
       
          data.append('property_id', this.newItem.id);
          data.append('property_type_id', this.newUnit.property_type_id);
          data.append('sale_type_id', this.newUnit.sale_type_id);

          var input = data;

           // var input = this.newItem;
            //alert(this.newItem.selected);
            this.$http.post(this.offlinePath+'/commprop/public/vuepropertiesAddunit',input).then((response) => {
                this.changePage(this.pagination.current_page);

                 this.newUnit = { 
                   'property_type_id':'',
                   'sale_type_id':'',
                   'size':'',
                   'price':'',
                };
                this.resetErrors();
                $("#create-unit").modal('hide');
                $(".modal-header button").click();

                toastr.success('Unit added successfully.', 'Success Alert', {timeOut: 5000});
              }, (response) => {
                this.formErrors = response.data;
                toastr.error('Error in form.', 'Warning', {timeOut: 5000});
              });


        },



      updateItem: function(id){

     
        //this.fillItem.selected = this.selectedAgent;
        var input = this.fillItem;
        this.$http.put(this.offlinePath+'/commprop/public/vueproperties/'+id,input).then((response) => {
            this.changePage(this.pagination.current_page);
            this.fillItem = {
              'id':'',
              'erf': '',
                'title':'',
                'description':'',
                'area_id':'',
                'image':'',

          };
            $("#edit-item").modal('hide');
            toastr.success('Property Updated Successfully.', 'Success Alert', {timeOut: 5000});
          }, (response) => {
              this.formErrorsUpdate = response.data;
              toastr.error('Error in form.', 'Warning', {timeOut: 5000});
          });
      },


      createPDF: function(item){

                  window.location.href = this.offlinePath+'/commprop/public/createpdf/'+item.id ;
                 
                 // this.$http.post('/laravel/commprop/public/createpdf/'+item.id).then((response) => {

                  //    toastr.success('Brochure created successfully.', 'Success Alert', {timeOut: 5000});
                  // });


      },




      resetSearch: function() {
         // $('.form-group').each(function () { $(this).closest("span").removeClass('error text-danger'); });
         //  $('.form-group').each(function () { $(this).removeClass('form-control'); });
      //    $( ".text-danger" ).remove();

        this.s_area= 0;
        this.s_stype= 0;
        this.s_ptype= 0;
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

      changePage: function (page) {
          this.pagination.current_page = page;
          // check if any search items selected
          if( this.s_area  || this.s_ptype  || this.s_stype   || this.s_minsize || this.s_maxsize ){
            console.log('searchVueItems');
            console.log(this.s_area);
            console.log(this.s_stype);
            console.log(this.s_ptype);
            console.log(this.s_minsize);
            console.log(this.s_maxsize);

            this.searchVueItems(page);
          }else{
            console.log('getVueItems');
            this.getVueItems(page);
          }



      }

  }

});