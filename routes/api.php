<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'auth'], function () {
    Route::post('login','AuthController@authenticate');
    Route::post('register','AuthController@authenticate');
    Route::get('logout','AuthController@logout');
    Route::get('check','AuthController@check');
});

// session route
Route::post('email-exist',[
    'as' => 'email-exist','uses' => 'Demo\PagesController@emailExist'
]);

// admin route
Route::group(['prefix' => 'admin', 'middleware' => 'api.auth'], function (){

	//Organizations
	Route::get('organizations/get', [
        'as' => 'admin.organizations', 'uses' => 'OrganizationsController@getAllOrganizations'
	]);

	Route::get('organizations/getOrganizationsForDropdown',[
		'as' => 'admin.organizations.getOrganizationsForDropdown', 'uses' => 'OrganizationsController@getOrganizationsForDropdown'
	]);

	Route::get('organizations/getOrganization/{id}',[
		'as' => 'admin.organizations.getOrganization', 'uses' => 'OrganizationsController@getOrganization'
	]);

	Route::resource('organizations', 'OrganizationsController', ['except' => ['create', 'edit']]);
	
	/** ------------------------------------------------------------------------------------------------------------------------- **/

	//Users
	Route::get('users/get', [
        'as' => 'admin.users', 'uses' => 'UsersController@getAllUsers'
	]);

	Route::get('users/getUsersForDropdown',[
		'as' => 'admin.users.getUsersForDropdown', 'uses' => 'UsersController@getUsersForDropdown'
	]);

	Route::get('users/getUser/{id}',[
		'as' => 'admin.users.getUser', 'uses' => 'UsersController@getUser'
	]);

	Route::resource('users', 'UsersController', ['except' => ['create', 'edit']]);
	
	/** ------------------------------------------------------------------------------------------------------------------------- **/

});

