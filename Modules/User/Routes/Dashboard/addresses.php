<?php

Route::group(['prefix' => 'user-addresses'], function () {

  	Route::get('/' ,'Dashboard\AddressController@index')
  	->name('dashboard.user_addresses.index')
    ->middleware(['permission:show_user_addresses']);

  	Route::get('datatable'	,'Dashboard\AddressController@datatable')
  	->name('dashboard.user_addresses.datatable')
  	->middleware(['permission:show_user_addresses']);

  	Route::get('create'		,'Dashboard\AddressController@create')
  	->name('dashboard.user_addresses.create')
    ->middleware(['permission:add_user_addresses']);

  	Route::post('/'			,'Dashboard\AddressController@store')
  	->name('dashboard.user_addresses.store')
    ->middleware(['permission:add_user_addresses']);

  	Route::get('{id}/edit'	,'Dashboard\AddressController@edit')
  	->name('dashboard.user_addresses.edit')
    ->middleware(['permission:edit_user_addresses']);

  	Route::put('{id}'		,'Dashboard\AddressController@update')
  	->name('dashboard.user_addresses.update')
    ->middleware(['permission:edit_user_addresses']);

  	Route::delete('{id}'	,'Dashboard\AddressController@destroy')
  	->name('dashboard.user_addresses.destroy')
    ->middleware(['permission:delete_user_addresses']);

  	Route::get('deletes'	,'Dashboard\AddressController@deletes')
  	->name('dashboard.user_addresses.deletes')
    ->middleware(['permission:delete_user_addresses']);

  	Route::get('{id}','Dashboard\AddressController@show')
  	->name('dashboard.user_addresses.show')
    ->middleware(['permission:show_user_addresses']);

});
