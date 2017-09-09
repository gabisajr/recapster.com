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
  Route::post('company/delete', ['as' => 'admin.company.delete', 'uses' => 'CompanyController@delete']);
  Route::get("company/images/{id}", ['as' => 'admin.company.images', 'uses' => 'CompanyController@images']);
  Route::get("company/jobs/{id}", ['as' => 'admin.company.jobs', 'uses' => 'CompanyController@jobs']);
  Route::post('company/addImages', ['as' => 'admin.company.addImages', 'uses' => 'CompanyController@addImages']);

  //job
  Route::get('jobs', ['as' => 'admin.jobs', 'uses' => 'JobController@list']);
  Route::get('job/create', ['as' => 'admin.job.create', 'uses' => 'JobController@create']);
  Route::get('job/edit/{id}', ['as' => 'admin.job.edit', 'uses' => 'JobController@edit']);
  Route::post('job/store', ['as' => 'admin.job.store', 'uses' => 'JobController@store']);
  Route::post('job/delete', ['as' => 'admin.job.delete', 'uses' => 'JobController@delete']);

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

  //universities vocabulary
  Route::get('universities/countries', ['as' => 'admin.universities.countries', 'uses' => 'UniversitiesController@countries']);
  Route::get('universities/cities/{country_id}', ['as' => 'admin.universities.cities', 'uses' => 'UniversitiesController@cities']);
  Route::get('universities', ['as' => 'admin.universities', 'uses' => 'UniversitiesController@universities']);
  Route::get('university/create', ['as' => 'admin.university.create', 'uses' => 'UniversitiesController@create']);
  Route::get('university/edit/{id}', ['as' => 'admin.university.edit', 'uses' => 'UniversitiesController@edit']);
  Route::post('university/store', ['as' => 'admin.university.store', 'uses' => 'UniversitiesController@store']);

  //faculties stuff
  Route::get('faculties', ['as' => 'admin.faculties', 'uses' => 'FacultiesController@faculties']);
  Route::get('faculty/create', ['as' => 'admin.faculty.create', 'uses' => 'FacultiesController@create']);
  Route::get('faculty/edit/{id}', ['as' => 'admin.faculty.edit', 'uses' => 'FacultiesController@edit']);
  Route::post('faculty/store', ['as' => 'admin.faculty.store', 'uses' => 'FacultiesController@store']);

  //chairs stuff
  Route::get('chairs', ['as' => 'admin.chairs', 'uses' => 'ChairsController@chairs']);
  Route::get('chair/create', ['as' => 'admin.chair.create', 'uses' => 'ChairsController@create']);
  Route::get('chair/edit/{id}', ['as' => 'admin.chair.edit', 'uses' => 'ChairsController@edit']);
  Route::post('chair/store', ['as' => 'admin.chair.store', 'uses' => 'ChairsController@store']);

  //users
  Route::get('users', ['as' => 'admin.users', 'uses' => 'UsersController@list']);
  Route::get('user/accounts/{id}', ['as' => 'admin.user.accounts', 'uses' => 'UsersController@accounts']);
  Route::post('user/delete', ['as' => 'admin.user.delete', 'uses' => 'UsersController@delete']);

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

//templates
Route::get('tmpl/{filepath}', ['as' => 'tmpl', 'uses' => 'TmplController@template'])
  ->where('filepath', '([a-zA-Z-_]+\/?)+') // some/dir/path
;

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

//search
Route::group(['namespace' => 'Search'], function () {
  Route::get('companies', ['as' => 'companies', 'uses' => 'CompaniesController@index']);
  Route::get('jobs', ['as' => 'jobs', 'uses' => 'JobsController@index']);
});

//fast search
Route::get('position/search', ['as' => 'position.search', 'uses' => 'PositionController@search']);
Route::get('company/search', ['as' => 'company.search', 'uses' => 'CompaniesController@search']);

Route::post('country/cities', ['as' => 'country.cities', 'uses' => 'CountryController@cities']);

//user auth
Route::group(['namespace' => 'Auth'], function () {

  //регистрация
  Route::get('signup', ['as' => 'signup', 'uses' => 'RegisterController@showRegistrationForm']);
  Route::post('signup', ['as' => 'signup', 'uses' => 'RegisterController@register']);

  //вход
  Route::get('signin', ['as' => 'signin', 'uses' => 'LoginController@showLoginForm']);
  Route::post('signin', ['as' => 'signin', 'uses' => 'LoginController@login']);

  //выход
  Route::post('signout', ['as' => 'signout', 'uses' => 'LoginController@logout']);

  //восстановление доступа
  Route::get('restore', ['as' => 'restore', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
  Route::post('restore', ['as' => 'restore', 'uses' => 'ForgotPasswordController@sendResetLinkEmail']);
  Route::get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'ResetPasswordController@showResetForm']);
  Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'ResetPasswordController@reset']);

});

//company
Route::group(['prefix' => 'company', 'namespace' => 'Company', 'middleware' => 'load.company'], function () {

  //company profile page
  Route::get('{company}', ['as' => 'company.profile', 'uses' => 'ProfileController@index']);

  //job page
  Route::get('{company}/job/{id}/{position}', ['as' => 'job-with-position', 'uses' => 'JobController@showJobPage']);
  Route::get('{company}/job/{id}', ['as' => 'job', 'uses' => 'JobController@showJobPage']);

});

//private area for user editing
Route::group(['prefix' => 'user', 'namespace' => 'User', 'middleware' => 'auth'], function () {

  //edit
  Route::group(['prefix' => 'edit', 'namespace' => 'Edit'], function () {

    //personal
    Route::get('personal', ['as' => 'user.edit.personal', 'uses' => 'PersonalController@showForm']);
    Route::post('personal', ['as' => 'user.edit.personal', 'uses' => 'PersonalController@store']);

    //contacts
    Route::get('contacts', ['as' => 'user.edit.contacts', 'uses' => 'ContactsController@showForm']);
    Route::post('contacts', ['as' => 'user.edit.contacts', 'uses' => 'ContactsController@store']);

    //education
    Route::get('education', ['as' => 'user.edit.education', 'uses' => 'EducationController@showForm']);
    Route::post('education', ['as' => 'user.edit.education', 'uses' => 'EducationController@store']);

  });

  //upload avatar
  Route::post('avatar/upload', ['as' => 'user.avatar.upload', 'uses' => 'AvatarController@upload']);

});

//user
Route::group(['prefix' => 'user', 'namespace' => 'User', 'middleware' => 'load.user'], function () {
  //user profile page
  Route::get('{username}', ['as' => 'user.profile', 'uses' => 'ProfileController@index']);
});