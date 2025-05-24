<?php

Route::group(['prefix' => 'cities'], function () {

  	Route::get('/' ,'Dashboard\CityController@index')
  	->name('dashboard.cities.index')
    ->middleware(['permission:show_cities']);

    Route::get('datatable'	,'Dashboard\CityController@datatable')
    ->name('dashboard.cities.datatable')
    ->middleware(['permission:show_cities']);

  	Route::get('create'		,'Dashboard\CityController@create')
  	->name('dashboard.cities.create')
    ->middleware(['permission:add_cities']);

  	Route::post('/'			,'Dashboard\CityController@store')
  	->name('dashboard.cities.store')
    ->middleware(['permission:add_cities']);

  	Route::get('{id}/edit'	,'Dashboard\CityController@edit')
  	->name('dashboard.cities.edit')
    ->middleware(['permission:edit_cities']);

  	Route::put('{id}'		,'Dashboard\CityController@update')
  	->name('dashboard.cities.update')
    ->middleware(['permission:edit_cities']);

  	Route::delete('{id}'	,'Dashboard\CityController@destroy')
  	->name('dashboard.cities.destroy')
    ->middleware(['permission:delete_cities']);

  	Route::get('deletes'	,'Dashboard\CityController@deletes')
  	->name('dashboard.cities.deletes')
    ->middleware(['permission:delete_cities']);

  	Route::get('{id}','Dashboard\CityController@show')
  	->name('dashboard.cities.show')
    ->middleware(['permission:show_cities']);

});
