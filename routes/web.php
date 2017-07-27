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
  Route::get('companies', ['as' => 'admin.company.list', 'uses' => 'CompanyController@list']);
  Route::get('company/create', ['as' => 'admin.company.create', 'uses' => 'CompanyController@create']);
  Route::get('company/edit/{id}', ['as' => 'admin.company.edit', 'uses' => 'CompanyController@edit']);
  Route::post('company/store', ['as' => 'admin.company.store', 'uses' => 'CompanyController@store']);
  Route::get("company/images/{id}", ['as' => 'admin.company.images', 'uses' => 'CompanyController@images']);
  Route::post('company/addImages', ['as' => 'admin.company.addImages', 'uses' => 'CompanyController@addImages']);

  //image
  Route::post('image/delete', ['as' => 'admin.image.delete', 'uses' => 'ImageController@delete']);

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


//company
Route::group(['namespace' => 'Company', 'middleware' => 'load.company'], function () {

  Route::get('{company}', ['as' => 'company.profile', 'uses' => 'ProfileController@index']);

});