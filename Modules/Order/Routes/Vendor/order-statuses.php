<?php

Route::group(['prefix' => 'order-statuses'], function () {

  	Route::get('/' ,'Dashboard\OrderStatusController@index')
  	->name('vendor.order-statuses.index')
    ->middleware(['permission:show_order_statuses']);

  	Route::get('datatable'	,'Dashboard\OrderStatusController@datatable')
  	->name('vendor.order-statuses.datatable')
  	->middleware(['permission:show_order_statuses']);

  	Route::get('create'		,'Dashboard\OrderStatusController@create')
  	->name('vendor.order-statuses.create')
    ->middleware(['permission:add_order_statuses']);

  	Route::post('/'			,'Dashboard\OrderStatusController@store')
  	->name('vendor.order-statuses.store')
    ->middleware(['permission:add_order_statuses']);

  	Route::get('{id}/edit'	,'Dashboard\OrderStatusController@edit')
  	->name('vendor.order-statuses.edit')
    ->middleware(['permission:edit_order_statuses']);

  	Route::put('{id}'		,'Dashboard\OrderStatusController@update')
  	->name('vendor.order-statuses.update')
    ->middleware(['permission:edit_order_statuses']);

  	Route::delete('{id}'	,'Dashboard\OrderStatusController@destroy')
  	->name('vendor.order-statuses.destroy')
    ->middleware(['permission:delete_order_statuses']);

  	Route::get('deletes'	,'Dashboard\OrderStatusController@deletes')
  	->name('vendor.order-statuses.deletes')
    ->middleware(['permission:delete_order_statuses']);

  	Route::get('{id}','Dashboard\OrderStatusController@show')
  	->name('vendor.order-statuses.show')
    ->middleware(['permission:show_order_statuses']);

});
