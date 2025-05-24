<?php

Route::group(['prefix' => 'delivery-charges', 'middleware' => 'CheckShippingCompany'], function () {

	Route::get('/', 'Dashboard\DeliveryChargeController@index')
		->name('dashboard.delivery-charges.index')
		->middleware(['permission:show_delivery_charges']);

	Route::get('datatable', 'Dashboard\DeliveryChargeController@datatable')
		->name('dashboard.delivery-charges.datatable')
		->middleware(['permission:show_delivery_charges']);

	Route::get('create', 'Dashboard\DeliveryChargeController@create')
		->name('dashboard.delivery-charges.create')
		->middleware(['permission:add_delivery_charges']);

	Route::post('/', 'Dashboard\DeliveryChargeController@store')
		->name('dashboard.delivery-charges.store')
		->middleware(['permission:add_delivery_charges']);

	Route::get('{id}/edit', 'Dashboard\DeliveryChargeController@edit')
		->name('dashboard.delivery-charges.edit')
		->middleware(['permission:edit_delivery_charges']);

	Route::put('{id}', 'Dashboard\DeliveryChargeController@update')
		->name('dashboard.delivery-charges.update')
		->middleware(['permission:edit_delivery_charges']);

	Route::delete('{id}', 'Dashboard\DeliveryChargeController@destroy')
		->name('dashboard.delivery-charges.destroy')
		->middleware(['permission:delete_delivery_charges']);

	Route::get('deletes', 'Dashboard\DeliveryChargeController@deletes')
		->name('dashboard.delivery-charges.deletes')
		->middleware(['permission:delete_delivery_charges']);

	Route::get('{id}', 'Dashboard\DeliveryChargeController@show')
		->name('dashboard.delivery-charges.show')
		->middleware(['permission:show_delivery_charges']);
});
