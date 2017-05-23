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

//Auth::routes();

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('sirregister', 'Auth\RegisterController@showRegistrationForm')->name('sirregister');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
//Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
//Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
//Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
//Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/users', 'UserController@index');
Route::get('/adminagents', 'AgentController@index');
//dropzone
Route::get('dropzone2', 'HomeController@dropzone');
Route::post('dropzone/store', ['as' => 'dropzone.store', 'uses' => 'HomeController@dropzoneStore']);

Route::get('/test', 'HomeController@test');

Route::get('/logs', 'LogsController@index');

Route::get('/clearlogs', 'LogsController@clearlog')->name('clearlogs');

Route::get('/dashboard', 'HomeController@dashboard');

Route::get('/dashboard2', 'HomeController@dashboard2');

Route::get('/dashboardmap', 'HomeController@dashboardmap');

Route::get('/owners', 'OwnerController@index');

Route::get('/properties', 'PropertyController@index');
Route::get('/psearch', 'PropertyController@search')->name('/psearch');

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/owners', 'OwnerController@index');

Route::post('/propsearch', 'HomeController@propsearch')->name('propsearch');
Route::get('/propsearch', 'HomeController@propsearch')->name('propsearch');

Route::get('/readme', 'HomeController@readme')->name('readme');

Route::get('/map', 'MapController@index')->name('map');

Route::get('/gotoProperty{id}', 'MapController@gotoProperty')->name('gotoProperty');

Route::get('/manage-properties', 'VuePropertyController@manageVue')->name('addProp');

// property crud
Route::resource('/vueproperties', 'VuePropertyController');

//search
//Route::post('searchvueproperties/{search}', 'VuePropertyController@search');
Route::post('searchvueproperties', 'VuePropertyController@search');

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

// set brochure
Route::post('/setbrochure', 'VuePropertyController@setbrochure');

// clear set brochures for user
Route::get('/clearbrochures', 'VuePropertyController@clearbrochures');

// brochure agent footer
Route::get('/brochurefooter{id}', 'VuePropertyController@brochurefooter')->name('brochurefooter');

//update property
Route::post('/updateproperty/{id}', 'VuePropertyController@updateproperty');

//update unit
Route::post('/updateunit/{id}', 'VuePropertyController@updateunit');

// list brochure
Route::get('/listbrochures', 'VuePropertyController@listbrochure');

// list brochure
Route::post('/delimage', 'VuePropertyController@delimage');

//test pdf
//Route::get('/createpdf/{input}', 'VuePropertyController@createPdf');
Route::get('/createpdf/{myinput}', 'VuePropertyController@createPdf');

// view property
//Route::resource('/showproperty', 'PropertyController');
Route::get('/showproperty{id}', 'PropertyController@show2');

////Route::get('/show2property{id}', 'PropertyController@show2');

Route::get('/showunit{id}', 'UnitController@show');

// User maintenance in dashboard
Route::get('manage-users', 'VueUserController@manageVue');
Route::resource('vueusers', 'VueUserController');
Route::post('/updateuser/{id}', 'VueUserController@updateuser');
Route::post('searchvueusers/{search}', 'VueUserController@search');
Route::get('/exportUsers', 'VueUserController@export')->name('exportUsers');

// Agent maintenance in dashboard
Route::get('manage-agents', 'VueAgentController@manageVue');
Route::resource('vueagents', 'VueAgentController');
Route::post('/updateagent/{id}', 'VueAgentController@updateagent');
Route::post('searchvueagents/{search}', 'VueAgentController@search');
Route::get('/exportAgents', 'VueAgentController@export')->name('exportAgents');

// Contacts maintenance in dashboard
Route::get('manage-contacts', 'VueContactController@manageVue');
Route::resource('vuecontacts', 'VueContactController');
Route::post('/updatecontact/{id}', 'VueContactController@updatecontact');
Route::post('searchvuecontacts/{search}', 'VueContactController@search');
Route::get('/exportContacts', 'VueContactController@export')->name('exportContacts');
// list contacts with properties
Route::get('/contactProp{id}', 'OwnerController@contactProp')->name('contactProp');

// Contacts maintenance in dashboard
Route::get('manage-units', 'VueUnitController@manageVue');
Route::resource('vueunits', 'VueUnitController');
// conflicting with properties updateunit
//Route::post('/vueupdateunit/{id}', 'VueUnitController@updateunit');
Route::post('searchvueunits/{search}', 'VueUnitController@search');
Route::get('/exportUnits', 'VueUnitController@export')->name('exportUnits');

// Documents maintenance in dashboard
Route::get('manage-documents', 'VueDocumentController@manageVue');
Route::resource('vuedocuments', 'VueDocumentController');
Route::post('/updatedocument/{id}', 'VueDocumentController@updatedocument');
Route::post('searchvuedocuments/{search}', 'VueDocumentController@search');
Route::get('/exportDocuments', 'VueDocumentController@export')->name('exportDocuments');
Route::get('/downloaddocument/{id}', 'VueDocumentController@download');
