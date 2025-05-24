<?php

Route::group(['prefix' => 'orders'], function () {

  	Route::get('/' ,'Driver\OrderController@index')
  	->name('driver.orders.index')
    ->middleware(['permission:show_orders']);

  	Route::get('datatable'	,'Driver\OrderController@datatable')
  	->name('driver.orders.datatable')
  	->middleware(['permission:show_orders']);

  	Route::get('create'		,'Driver\OrderController@create')
  	->name('driver.orders.create')
    ->middleware(['permission:add_orders']);

  	Route::post('/'			,'Driver\OrderController@store')
  	->name('driver.orders.store')
    ->middleware(['permission:add_orders']);

  	Route::get('{id}/edit'	,'Driver\OrderController@edit')
  	->name('driver.orders.edit')
    ->middleware(['permission:edit_orders']);

  	Route::put('{id}'		,'Driver\OrderController@update')
  	->name('driver.orders.update')
    ->middleware(['permission:edit_orders']);

  	Route::delete('{id}'	,'Driver\OrderController@destroy')
  	->name('driver.orders.destroy')
    ->middleware(['permission:delete_orders']);

  	Route::get('deletes'	,'Driver\OrderController@deletes')
  	->name('driver.orders.deletes')
    ->middleware(['permission:delete_orders']);

  	Route::get('{id}','Driver\OrderController@show')
  	->name('driver.orders.show')
    ->middleware(['permission:show_orders']);

});
