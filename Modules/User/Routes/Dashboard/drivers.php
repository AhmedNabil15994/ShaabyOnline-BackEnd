<?php

Route::group(['prefix' => 'drivers'], function () {

  	Route::get('/' ,'Dashboard\DriverController@index')
  	->name('dashboard.drivers.index')
    ->middleware(['permission:show_drivers']);

  	Route::get('datatable'	,'Dashboard\DriverController@datatable')
  	->name('dashboard.drivers.datatable')
  	->middleware(['permission:show_drivers']);

  	Route::get('create'		,'Dashboard\DriverController@create')
  	->name('dashboard.drivers.create')
    ->middleware(['permission:add_drivers']);

  	Route::post('/'			,'Dashboard\DriverController@store')
  	->name('dashboard.drivers.store')
    ->middleware(['permission:add_drivers']);

  	Route::get('{id}/edit'	,'Dashboard\DriverController@edit')
  	->name('dashboard.drivers.edit')
    ->middleware(['permission:edit_drivers']);

  	Route::put('{id}'		,'Dashboard\DriverController@update')
  	->name('dashboard.drivers.update')
    ->middleware(['permission:edit_drivers']);

  	Route::delete('{id}'	,'Dashboard\DriverController@destroy')
  	->name('dashboard.drivers.destroy')
    ->middleware(['permission:delete_drivers']);

  	Route::get('deletes'	,'Dashboard\DriverController@deletes')
  	->name('dashboard.drivers.deletes')
    ->middleware(['permission:delete_drivers']);

  	Route::get('{id}','Dashboard\DriverController@show')
  	->name('dashboard.drivers.show')
    ->middleware(['permission:show_drivers']);

});
