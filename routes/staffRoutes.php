<?php

use Illuminate\Support\Facades\Route;

route::group(['middleware' => 'auth:admin', 'namespace' => 'Staff'], function(){

	// staff routes
	Route::get('admin/staff/create', 'StaffController@create')->name('staff.create');
	Route::post('admin/staff/store', 'StaffController@store')->name('staff.store');
	Route::get('admin/staff/list', 'StaffController@staffList')->name('staff.list');
	Route::get('admin/staff/{id}/edit', 'StaffController@edit')->name('staff.edit');
	Route::post('admin/staff/update', 'StaffController@update')->name('staff.update');
	Route::get('admin/staff/delete/{id}', 'StaffController@delete')->name('staff.delete');
	Route::get('admin/staff/profile/{username}', 'StaffController@staffProfile')->name('staff.profile');
	Route::get('admin/staff/secret/login/{id}', 'StaffController@staffSecretLogin')->name('admin.staffSecretLogin');

	
});






