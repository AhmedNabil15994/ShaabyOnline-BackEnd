<?php

Route::group(['prefix' => 'roles'], function () {

  	Route::get('/' ,'Dashboard\RoleController@index')
  	->name('dashboard.roles.index')
    ->middleware(['permission:show_roles']);

  	Route::get('datatable'	,'Dashboard\RoleController@datatable')
  	->name('dashboard.roles.datatable')
  	->middleware(['permission:show_roles']);

  	Route::get('create'		,'Dashboard\RoleController@create')
  	->name('dashboard.roles.create')
    ->middleware(['permission:add_roles']);

  	Route::post('/'			,'Dashboard\RoleController@store')
  	->name('dashboard.roles.store')
    ->middleware(['permission:add_roles']);

  	Route::get('{id}/edit'	,'Dashboard\RoleController@edit')
  	->name('dashboard.roles.edit')
    ->middleware(['permission:edit_roles']);

  	Route::put('{id}'		,'Dashboard\RoleController@update')
  	->name('dashboard.roles.update')
    ->middleware(['permission:edit_roles']);

  	Route::delete('{id}'	,'Dashboard\RoleController@destroy')
  	->name('dashboard.roles.destroy')
    ->middleware(['permission:delete_roles']);

  	Route::get('deletes'	,'Dashboard\RoleController@deletes')
  	->name('dashboard.roles.deletes')
    ->middleware(['permission:delete_roles']);

  	Route::get('{id}','Dashboard\RoleController@show')
  	->name('dashboard.roles.show')
    ->middleware(['permission:show_roles']);

});
