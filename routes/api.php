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

	//Corrective Actions
	Route::get('corrective_actions/get', [
        'as' => 'admin.corrective_actions', 'uses' => 'CorrectiveActionsController@getAllCorrectiveActions'
	]);

	Route::get('corrective_actions/getCorrectiveActionsForDropdown',[
		'as' => 'admin.corrective_actions.getCorrectiveActionsForDropdown', 'uses' => 'CorrectiveActionsController@getCorrectiveActionsForDropdown'
	]);

	Route::get('corrective_actions/getCorrectiveAction/{id}',[
		'as' => 'admin.corrective_actions.getCorrectiveAction', 'uses' => 'CorrectiveActionsController@getCorrectiveAction'
	]);

	Route::resource('corrective_actions', 'CorrectiveActionsController', ['except' => ['create', 'edit']]);

	/** ------------------------------------------------------------------------------------------------------------------------- **/

	//Individual Comments
	Route::get('individual_comments/get', [
        'as' => 'admin.individual_comments', 'uses' => 'IndividualCommentsController@getAllIndividualComments'
	]);

	Route::get('individual_comments/getIndividualComment/{id}',[
		'as' => 'admin.individual_comments.getIndividualComment', 'uses' => 'IndividualCommentsController@getIndividualComment'
	]);

	Route::get('individual_comments/getIndividualCommentsByCorrectiveActionID/{id}',[
		'as' => 'admin.individual_comments.getIndividualCommentsByCorrectiveActionID', 'uses' => 'IndividualCommentsController@getIndividualCommentsByCorrectiveActionID'
	]);

	Route::post('individual_comments/bulk_update', [
        'as' => 'admin.individual_comments.bulk_update', 'uses' => 'IndividualCommentsController@bulkUpdate'
	]);

	Route::resource('individual_comments', 'IndividualCommentsController', ['except' => ['create', 'edit']]);

	/** ------------------------------------------------------------------------------------------------------------------------- **/

	//Suppliers
	Route::get('suppliers/get', [
        'as' => 'admin.suppliers', 'uses' => 'SuppliersController@getAllSuppliers'
	]);

	Route::get('suppliers/getSupplier/{id}',[
		'as' => 'admin.suppliers.getSupplier', 'uses' => 'SuppliersController@getSupplier'
	]);

	Route::get('suppliers/getSuppliersForDropdown',[
		'as' => 'admin.suppliers.getSuppliersForDropdown', 'uses' => 'SuppliersController@getSuppliersForDropdown'
	]);

	Route::get('suppliers/getSuppliersByOrganizationID/{id}',[
		'as' => 'admin.suppliers.getSuppliersByOrganizationID', 'uses' => 'SuppliersController@getSuppliersByOrganizationID'
	]);

	Route::resource('suppliers', 'SuppliersController', ['except' => ['create', 'edit']]);
	
	/** ------------------------------------------------------------------------------------------------------------------------- **/

	//Type of Foods
	Route::get('type_of_foods/get', [
        'as' => 'admin.type_of_foods', 'uses' => 'TypeOfFoodsController@getAllTypeOfFoods'
	]);

	Route::get('type_of_foods/getTypeOfFood/{id}',[
		'as' => 'admin.type_of_foods.getTypeOfFood', 'uses' => 'TypeOfFoodsController@getTypeOfFood'
	]);

	Route::get('type_of_foods/getTypeOfFoodsForDropdown',[
		'as' => 'admin.type_of_foods.getTypeOfFoodsForDropdown', 'uses' => 'TypeOfFoodsController@getTypeOfFoodsForDropdown'
	]);

	Route::get('type_of_foods/getTypeOfFoodsByOrganizationID/{id}',[
		'as' => 'admin.type_of_foods.getTypeOfFoodsByOrganizationID', 'uses' => 'TypeOfFoodsController@getTypeOfFoodsByOrganizationID'
	]);

	Route::resource('type_of_foods', 'TypeOfFoodsController', ['except' => ['create', 'edit']]);
	
	/** ------------------------------------------------------------------------------------------------------------------------- **/

	//Staff Daily Checklists
	Route::get('staff_daily_checklists/get', [
        'as' => 'admin.staff_daily_checklists', 'uses' => 'StaffDailyChecklistsController@getAllStaffDailyChecklists'
	]);

	Route::get('staff_daily_checklists/getStaffDailyChecklist/{id}',[
		'as' => 'admin.staff_daily_checklists.getStaffDailyChecklist', 'uses' => 'StaffDailyChecklistsController@getStaffDailyChecklist'
	]);

	Route::get('staff_daily_checklists/getStaffDailyChecklistsForDropdown',[
		'as' => 'admin.staff_daily_checklists.getStaffDailyChecklistsForDropdown', 'uses' => 'StaffDailyChecklistsController@getStaffDailyChecklistsForDropdown'
	]);

	Route::resource('staff_daily_checklists', 'StaffDailyChecklistsController', ['except' => ['create', 'edit']]);

	/** ------------------------------------------------------------------------------------------------------------------------- **/

	//Matrix Checklists
	Route::get('matrix_checklists/get', [
        'as' => 'admin.matrix_checklists', 'uses' => 'MatrixChecklistsController@getAllMatrixChecklists'
	]);

	Route::get('matrix_checklists/getMatrixChecklist/{id}',[
		'as' => 'admin.matrix_checklists.getMatrixChecklist', 'uses' => 'MatrixChecklistsController@getMatrixChecklist'
	]);

	Route::get('matrix_checklists/getMatrixChecklistsForDropdown',[
		'as' => 'admin.matrix_checklists.getMatrixChecklistsForDropdown', 'uses' => 'MatrixChecklistsController@getMatrixChecklistsForDropdown'
	]);

	Route::resource('matrix_checklists', 'MatrixChecklistsController', ['except' => ['create', 'edit']]);
	
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

	Route::get('checklist_areas/getChecklistAreasByOrganizationID/{id}',[
		'as' => 'admin.checklist_areas.getChecklistAreasByOrganizationID', 'uses' => 'ChecklistAreasController@getChecklistAreasByOrganizationID'
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

	Route::get('checklist_times/getChecklistTimesByOrganizationID/{id}',[
		'as' => 'admin.checklist_times.getChecklistTimesByOrganizationID', 'uses' => 'ChecklistTimesController@getChecklistTimesByOrganizationID'
	]);

	Route::resource('checklist_times', 'ChecklistTimesController', ['except' => ['create', 'edit']]);
	
	/** ------------------------------------------------------------------------------------------------------------------------- **/

	//Checklist Categories
	Route::get('checklist_categories/get', [
        'as' => 'admin.checklist_categories', 'uses' => 'ChecklistCategoriesController@getAllChecklistCategories'
	]);

	Route::get('checklist_categories/getChecklistTimesForDropdown',[
		'as' => 'admin.checklist_categories.getChecklistCategoriesForDropdown', 'uses' => 'ChecklistCategoriesController@getChecklistCategoriesForDropdown'
	]);

	Route::get('checklist_categories/getChecklistCategory/{id}',[
		'as' => 'admin.checklist_categories.getChecklistCategory', 'uses' => 'ChecklistCategoriesController@getChecklistCategory'
	]);

	Route::get('checklist_categories/getChecklistCategoriesByOrganizationID/{id}',[
		'as' => 'admin.checklist_categories.getChecklistCategoriesByOrganizationID', 'uses' => 'ChecklistCategoriesController@getChecklistCategoriesByOrganizationID'
	]);

	Route::resource('checklist_categories', 'ChecklistCategoriesController', ['except' => ['create', 'edit']]);
	
	/** ------------------------------------------------------------------------------------------------------------------------- **/

	//Checklist Items
	Route::get('checklist_items/get', [
        'as' => 'admin.checklist_items', 'uses' => 'ChecklistItemsController@getAllChecklistItems'
	]);

	Route::get('checklist_items/getChecklistItemsForDropdown',[
		'as' => 'admin.checklist_items.getChecklistItemsForDropdown', 'uses' => 'ChecklistItemsController@getChecklistItemsForDropdown'
	]);

	Route::get('checklist_items/getChecklistItem/{id}',[
		'as' => 'admin.checklist_items.getChecklistItem', 'uses' => 'ChecklistItemsController@getChecklistItem'
	]);

	Route::get('checklist_items/getChecklistItemsByOrganizationID/{id}',[
		'as' => 'admin.checklist_items.getChecklistItemsByOrganizationID', 'uses' => 'ChecklistItemsController@getChecklistItemsByOrganizationID'
	]);

	Route::resource('checklist_items', 'ChecklistItemsController', ['except' => ['create', 'edit']]);
	
	/** ------------------------------------------------------------------------------------------------------------------------- **/

	//Manage Checklists
	Route::get('manage_checklists/get', [
        'as' => 'admin.manage_checklists', 'uses' => 'ManageChecklistsController@getAllManageChecklists'
	]);

	Route::get('manage_checklists/getManageChecklistsForDropdown',[
		'as' => 'admin.manage_checklists.getManageChecklistsForDropdown', 'uses' => 'ManageChecklistsController@getManageChecklistsForDropdown'
	]);

	Route::get('manage_checklists/getManageChecklist/{id}',[
		'as' => 'admin.manage_checklists.getManageChecklist', 'uses' => 'ManageChecklistsController@getManageChecklist'
	]);

	Route::get('manage_checklists/getChecklistItems',[
		'as' => 'admin.manage_checklists.getChecklistItems', 'uses' => 'ManageChecklistsController@getChecklistItems'
	]);

	Route::resource('manage_checklists', 'ManageChecklistsController', ['except' => ['create', 'edit']]);
	
	/** ------------------------------------------------------------------------------------------------------------------------- **/

});

