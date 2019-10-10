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

	//Probes
	Route::get('probes/get', [
        'as' => 'admin.probes', 'uses' => 'ProbesController@getAllProbes'
	]);

	Route::get('probes/getProbe/{id}',[
		'as' => 'admin.probes.getProbe', 'uses' => 'ProbesController@getProbe'
	]);

	Route::get('probes/getProbesForDropdown',[
		'as' => 'admin.probes.getProbesForDropdown', 'uses' => 'ProbesController@getProbesForDropdown'
	]);

	Route::resource('probes', 'ProbesController', ['except' => ['create', 'edit']]);
	
	/** ------------------------------------------------------------------------------------------------------------------------- **/

	//Organizations
	Route::get('organizations/get', [
        'as' => 'admin.organizations', 'uses' => 'OrganizationsController@getAllOrganizations'
	]);

	Route::get('organizations/getOrganization/{id}',[
		'as' => 'admin.organizations.getOrganization', 'uses' => 'OrganizationsController@getOrganization'
	]);

	Route::get('organizations/getOrganizationsForDropdown',[
		'as' => 'admin.organizations.getOrganizationsForDropdown', 'uses' => 'OrganizationsController@getOrganizationsForDropdown'
	]);

	Route::resource('organizations', 'OrganizationsController', ['except' => ['create', 'edit']]);
	
	/** ------------------------------------------------------------------------------------------------------------------------- **/

	//Locations
	Route::get('locations/get', [
        'as' => 'admin.locations', 'uses' => 'LocationsController@getAllLocations'
	]);

	Route::get('locations/getLocationsForDropdown',[
		'as' => 'admin.locations.getLocationsForDropdown', 'uses' => 'LocationsController@getLocationsForDropdown'
	]);

	Route::get('locations/getLocation/{id}',[
		'as' => 'admin.locations.getLocation', 'uses' => 'LocationsController@getLocation'
	]);

	Route::get('locations/getLocationsByOrganizationID/{id}',[
		'as' => 'admin.locations.getLocationsByOrganizationID', 'uses' => 'LocationsController@getLocationsByOrganizationID'
	]);

	Route::resource('locations', 'LocationsController', ['except' => ['create', 'edit']]);
	
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

	//Checklist Areas
	Route::get('checklist_areas/get', [
        'as' => 'admin.checklist_areas', 'uses' => 'ChecklistAreasController@getAllChecklistAreas'
	]);

	Route::get('checklist_areas/getChecklistAreasForDropdown',[
		'as' => 'admin.checklist_areas.getChecklistAreasForDropdown', 'uses' => 'ChecklistAreasController@getChecklistAreasForDropdown'
	]);

	Route::get('checklist_areas/getChecklistArea/{id}',[
		'as' => 'admin.checklist_areas.getChecklistArea', 'uses' => 'ChecklistAreasController@getChecklistArea'
	]);

	Route::resource('checklist_areas', 'ChecklistAreasController', ['except' => ['create', 'edit']]);
	
	/** ------------------------------------------------------------------------------------------------------------------------- **/

	//Checklist Times
	Route::get('checklist_times/get', [
        'as' => 'admin.checklist_times', 'uses' => 'ChecklistTimesController@getAllChecklistTimes'
	]);

	Route::get('checklist_times/getChecklistTimesForDropdown',[
		'as' => 'admin.checklist_times.getChecklistTimesForDropdown', 'uses' => 'ChecklistTimesController@getChecklistTimesForDropdown'
	]);

	Route::get('checklist_times/getChecklistTime/{id}',[
		'as' => 'admin.checklist_times.getChecklistTime', 'uses' => 'ChecklistTimesController@getChecklistTime'
	]);

	Route::resource('checklist_times', 'ChecklistTimesController', ['except' => ['create', 'edit']]);
	
	/** ------------------------------------------------------------------------------------------------------------------------- **/

});

