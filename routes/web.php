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