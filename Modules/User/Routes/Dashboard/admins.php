<?php

Route::group(['prefix' => 'admins'], function () {

  	Route::get('/' ,'Dashboard\AdminController@index')
  	->name('dashboard.admins.index')
    ->middleware(['permission:show_admins']);

  	Route::get('datatable'	,'Dashboard\AdminController@datatable')
  	->name('dashboard.admins.datatable')
  	->middleware(['permission:show_admins']);

  	Route::get('create'		,'Dashboard\AdminController@create')
  	->name('dashboard.admins.create')
    ->middleware(['permission:add_admins']);

  	Route::post('/'			,'Dashboard\AdminController@store')
  	->name('dashboard.admins.store')
    ->middleware(['permission:add_admins']);

  	Route::get('{id}/edit'	,'Dashboard\AdminController@edit')
  	->name('dashboard.admins.edit')
    ->middleware(['permission:edit_admins']);

  	Route::put('{id}'		,'Dashboard\AdminController@update')
  	->name('dashboard.admins.update')
    ->middleware(['permission:edit_admins']);

  	Route::delete('{id}'	,'Dashboard\AdminController@destroy')
  	->name('dashboard.admins.destroy')
    ->middleware(['permission:delete_admins']);

  	Route::get('deletes'	,'Dashboard\AdminController@deletes')
  	->name('dashboard.admins.deletes')
    ->middleware(['permission:delete_admins']);

  	Route::get('{id}','Dashboard\AdminController@show')
  	->name('dashboard.admins.show')
    ->middleware(['permission:show_admins']);

});
