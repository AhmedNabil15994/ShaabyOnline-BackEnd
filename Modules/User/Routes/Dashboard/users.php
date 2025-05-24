<?php

Route::group(['prefix' => 'users'], function () {

  	Route::get('/' ,'Dashboard\UserController@index')
  	->name('dashboard.users.index')
    ->middleware(['permission:show_users']);

  	Route::get('datatable'	,'Dashboard\UserController@datatable')
  	->name('dashboard.users.datatable')
  	->middleware(['permission:show_users']);

  	Route::get('create'		,'Dashboard\UserController@create')
  	->name('dashboard.users.create')
    ->middleware(['permission:add_users']);

  	Route::post('/'			,'Dashboard\UserController@store')
  	->name('dashboard.users.store')
    ->middleware(['permission:add_users']);

  	Route::get('{id}/edit'	,'Dashboard\UserController@edit')
  	->name('dashboard.users.edit')
    ->middleware(['permission:edit_users']);

  	Route::put('{id}'		,'Dashboard\UserController@update')
  	->name('dashboard.users.update')
    ->middleware(['permission:edit_users']);

  	Route::delete('{id}'	,'Dashboard\UserController@destroy')
  	->name('dashboard.users.destroy')
    ->middleware(['permission:delete_users']);

  	Route::get('deletes'	,'Dashboard\UserController@deletes')
  	->name('dashboard.users.deletes')
    ->middleware(['permission:delete_users']);

  	Route::get('{id}','Dashboard\UserController@show')
  	->name('dashboard.users.show')
    ->middleware(['permission:show_users']);

});
