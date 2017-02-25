
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.http.interceptors.push(function (request, next) {
    request.headers['X-CSRF-TOKEN'] = Laravel.csrfToken;
    next();
});


Vue.component('example', require('./components/Example.vue'));

Vue.component('drop', require('./components/DropDown.vue'));



const app = new Vue({
    el: '#app',



    data: {
       
       options: [{name: 'paul', messgae: 'hello'},
                  {name: 'mito', message: 'fuck off'}
                  ],
        selected:  [{name: 'mito', message: 'fuck off'}],
        value: []

    },




});
