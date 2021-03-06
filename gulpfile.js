const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */
// gulpfile.js


elixir((mix) => {
	mix.copy('node_modules/font-awesome/fonts','public/build/fonts')
    mix.sass('app.scss')
       .webpack('app.js')
       .webpack('properties.js')
       .webpack('users.js')
       .webpack('agents.js')
       .webpack('contacts.js')
       .webpack('units.js')
       .webpack('documents.js')
       ;
});
