<?php

Route::group(['prefix' => 'permissions', 'middleware' => ['tocaan.user']], function () {

	Route::get('/', 'Dashboard\PermissionController@index')
		->name('dashboard.permissions.index');

	Route::get('datatable', 'Dashboard\PermissionController@datatable')
		->name('dashboard.permissions.datatable');

	Route::get('create', 'Dashboard\PermissionController@create')
		->name('dashboard.permissions.create');

	Route::post('/', 'Dashboard\PermissionController@store')
		->name('dashboard.permissions.store');

	Route::get('{id}/edit', 'Dashboard\PermissionController@edit')
		->name('dashboard.permissions.edit');

	Route::put('{id}', 'Dashboard\PermissionController@update')
		->name('dashboard.permissions.update');

	Route::delete('{id}', 'Dashboard\PermissionController@destroy')
		->name('dashboard.permissions.destroy');

	Route::get('deletes', 'Dashboard\PermissionController@deletes')
		->name('dashboard.permissions.deletes');

	Route::get('{id}', 'Dashboard\PermissionController@show')
		->name('dashboard.permissions.show');
});
