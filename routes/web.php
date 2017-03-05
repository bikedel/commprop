<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/propsearch', 'HomeController@propsearch')->name('propsearch');
Route::get('/propsearch', 'HomeController@propsearch')->name('propsearch');

Route::get('/readme', 'HomeController@readme')->name('readme');

Route::get('/map', 'MapController@index')->name('map');

Route::get('/manage-properties', 'VuePropertyController@manageVue')->name('addProp');

// property crud
Route::resource('/vueproperties', 'VuePropertyController');

//search
Route::post('searchvueproperties/{search}', 'VuePropertyController@search');

// inlude relation tables
Route::get('/vuepropertiesSelects', 'VuePropertyController@selects');

//add unit
Route::post('/vuepropertiesAddunit', 'VuePropertyController@addunit');

// delete unit
Route::delete('/vuepropertiesDeleteUnit/{id}', 'VuePropertyController@deleteunit');

// addd note
Route::post('/vuepropertiesAddNote', 'VuePropertyController@addnote');

// addd owner
Route::post('/vuepropertiesAddOwner', 'VuePropertyController@addowner');

//test pdf
Route::get('/createpdf/{item}', 'VuePropertyController@createPdf');

// view property
//Route::resource('/showproperty', 'PropertyController');
Route::get('/showproperty{id}', 'PropertyController@show');
