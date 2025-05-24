<?php

Route::group(['prefix' => 'advertising'], function () {

  	Route::get('/' ,'Dashboard\AdvertisingController@index')
  	->name('dashboard.advertising.index')
    ->middleware(['permission:show_advertising']);

    Route::get('datatable'	,'Dashboard\AdvertisingController@datatable')
    ->name('dashboard.advertising.datatable')
    ->middleware(['permission:show_advertising']);

  	Route::get('create'		,'Dashboard\AdvertisingController@create')
  	->name('dashboard.advertising.create')
    ->middleware(['permission:add_advertising']);

  	Route::post('/'			,'Dashboard\AdvertisingController@store')
  	->name('dashboard.advertising.store')
    ->middleware(['permission:add_advertising']);

  	Route::get('{id}/edit'	,'Dashboard\AdvertisingController@edit')
  	->name('dashboard.advertising.edit')
    ->middleware(['permission:edit_advertising']);

  	Route::put('{id}'		,'Dashboard\AdvertisingController@update')
  	->name('dashboard.advertising.update')
    ->middleware(['permission:edit_advertising']);

  	Route::delete('{id}'	,'Dashboard\AdvertisingController@destroy')
  	->name('dashboard.advertising.destroy')
    ->middleware(['permission:delete_advertising']);

  	Route::get('deletes'	,'Dashboard\AdvertisingController@deletes')
  	->name('dashboard.advertising.deletes')
    ->middleware(['permission:delete_advertising']);

  	Route::get('{id}','Dashboard\AdvertisingController@show')
  	->name('dashboard.advertising.show')
    ->middleware(['permission:show_advertising']);

});
