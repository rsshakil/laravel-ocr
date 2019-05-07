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
    return view('frontend.welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// Authentication Route
Route::group(['middleware'=>'MyMiddleWire'],function(){

	// Role permission Route
	// Route::group(['middleware' => ['role:Super Admin']], function () {
		
		// Route::get('/user_create', 'PermissionController@permission')->name('permission');
        Route::get('/permission', 'PermissionController@permission')->name('permission');
		Route::post('/permission_insert', 'PermissionController@permissionInsert');
		Route::get('/permission_delete/{permission_id}', 'PermissionController@permissionDelete');

		Route::get('/role', 'RoleController@role')->name('role');
		Route::get('/create_role', 'RoleController@create_role')->name('create_role');
		Route::post('/role_insert', 'RoleController@roleInsert');
		Route::get('/role_delete/{role_id}', 'RoleController@roleDelete');


		Route::get('/assign_permission_role', 'RoleController@assignPermissionRole');

		Route::get('get_permission/{role_id}', 'RoleController@getPermission');
		Route::post('assign_permission_role', 'RoleController@assignPermissionToRole');

		Route::get('/assign_permission_model', 'RoleController@assignPermissionToModel');
		Route::post('/assign_permission_model', 'RoleController@assignPermissionToModelStore');

        Route::get('get_permission_model/{user_id}', 'RoleController@getPermissionModel');


		Route::get('assign_role_model', 'RoleController@assignRoleModel');
		Route::get('get_role/{user_id}', 'RoleController@getRole');
		Route::post('assign_model_role', 'RoleController@assignModelRole');

		Route::post('user_create', 'UserManagement@userCreate');
        Route::get('user_delete/{user_id}', 'UserManagement@userDelete');
		Route::get('user_list', 'UserManagement@userList');
		Route::get('user_update/{user_id}', 'UserManagement@userDetails');

		Route::post('update_user', 'UserManagement@userUpdate');
		Route::post('change_password', 'UserManagement@changePassword');
		// Route::post('user_change_password', 'UserManagement@userChangePassword');

		// Code Added by Ahasan from 
		Route::post('user_update', 'UserManagement@userUpdate');
		Route::get('get_permission_by_role_id/{user_id}', 'RoleController@get_role_permission_by_role_id');

	// });
		
});

