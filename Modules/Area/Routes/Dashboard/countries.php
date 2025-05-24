<?php

Route::group(['prefix' => 'countries'], function () {

  	Route::get('/' ,'Dashboard\CountryController@index')
  	->name('dashboard.countries.index')
    ->middleware(['permission:show_countries']);

  	Route::get('datatable'	,'Dashboard\CountryController@datatable')
  	->name('dashboard.countries.datatable')
  	->middleware(['permission:show_countries']);

  	Route::get('create'		,'Dashboard\CountryController@create')
  	->name('dashboard.countries.create')
    ->middleware(['permission:add_countries']);

  	Route::post('/'			,'Dashboard\CountryController@store')
  	->name('dashboard.countries.store')
    ->middleware(['permission:add_countries']);

  	Route::get('{id}/edit'	,'Dashboard\CountryController@edit')
  	->name('dashboard.countries.edit')
    ->middleware(['permission:edit_countries']);

  	Route::put('{id}'		,'Dashboard\CountryController@update')
  	->name('dashboard.countries.update')
    ->middleware(['permission:edit_countries']);

  	Route::delete('{id}'	,'Dashboard\CountryController@destroy')
  	->name('dashboard.countries.destroy')
    ->middleware(['permission:delete_countries']);

  	Route::get('deletes'	,'Dashboard\CountryController@deletes')
  	->name('dashboard.countries.deletes')
    ->middleware(['permission:delete_countries']);

  	Route::get('{id}','Dashboard\CountryController@show')
  	->name('dashboard.countries.show')
    ->middleware(['permission:show_countries']);

});
