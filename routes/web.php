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

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

  Route::get('/', ['as' => 'admin', 'uses' => 'CompanyController@list']); //todo replace by admin dashboard page

  //company
  Route::get('companies', ['as' => 'admin.companies', 'uses' => 'CompanyController@list']);
  Route::get('company/create', ['as' => 'admin.company.create', 'uses' => 'CompanyController@create']);
  Route::get('company/edit/{id}', ['as' => 'admin.company.edit', 'uses' => 'CompanyController@edit']);
  Route::post('company/store', ['as' => 'admin.company.store', 'uses' => 'CompanyController@store']);
  Route::get("company/images/{id}", ['as' => 'admin.company.images', 'uses' => 'CompanyController@images']);
  Route::post('company/addImages', ['as' => 'admin.company.addImages', 'uses' => 'CompanyController@addImages']);

  //job
  Route::get('jobs', ['as' => 'admin.jobs', 'uses' => 'JobController@list']);
  Route::get('job/create', ['as' => 'admin.job.create', 'uses' => 'JobController@create']);
  Route::post('job/store', ['as' => 'admin.job.store', 'uses' => 'JobController@store']);

  //image
  Route::post('image/delete', ['as' => 'admin.image.delete', 'uses' => 'ImageController@delete']);

  //vocabularies
  Route::get('vocabularies', ['as' => 'admin.vocabularies', 'uses' => 'VocabulariesController@list']);

  //positions vocabulary
  Route::get('positions', ['as' => 'admin.positions', 'uses' => 'PositionsController@list']);
  Route::get('position/create', ['as' => 'admin.position.create', 'uses' => 'PositionsController@create']);
  Route::get('position/edit/{id}', ['as' => 'admin.position.edit', 'uses' => 'PositionsController@edit']);
  Route::post('position/store', ['as' => 'admin.position.store', 'uses' => 'PositionsController@store']);
  Route::post('position/delete', ['as' => 'admin.position.delete', 'uses' => 'PositionsController@delete']);

  //admin auth
  Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::get('login', ['as' => 'admin.login', 'uses' => 'LoginController@showLoginForm']);
    Route::post('login', ['as' => 'admin.login.submit', 'uses' => 'LoginController@login']);
    Route::post('logout', ['as' => 'admin.logout', 'uses' => 'LoginController@logout']);
    Route::get('password/reset', ['as' => 'admin.password.request', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/email', ['as' => 'admin.password.email', 'uses' => 'ForgotPasswordController@sendResetLinkEmail']);
    Route::get('password/reset/{token}', ['as' => 'admin.password.reset', 'uses' => 'ResetPasswordController@showResetForm']);
    Route::post('password/reset', ['as' => 'admin.password.reset.post', 'uses' => 'ResetPasswordController@reset']);
  });

});

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('companies', ['as' => 'companies', 'uses' => 'CompaniesController@index']);

//position
Route::get('position/search', ['as' => 'position.search', 'uses' => 'PositionController@search']);

//company
Route::group(['namespace' => 'Company', 'middleware' => 'load.company'], function () {

  Route::get('{company}', ['as' => 'company.profile', 'uses' => 'ProfileController@index']);

});