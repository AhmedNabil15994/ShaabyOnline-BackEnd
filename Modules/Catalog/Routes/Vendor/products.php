<?php

Route::group(['prefix' => 'products'], function () {

  	Route::get('/' ,'Vendor\ProductController@index')
  	->name('vendor.products.index')
    ->middleware(['permission:show_products']);

  	Route::get('datatable'	,'Vendor\ProductController@datatable')
  	->name('vendor.products.datatable')
  	->middleware(['permission:show_products']);

  	Route::get('create'		,'Vendor\ProductController@create')
  	->name('vendor.products.create')
    ->middleware(['permission:add_products']);

  	Route::post('/'			,'Vendor\ProductController@store')
  	->name('vendor.products.store')
    ->middleware(['permission:add_products']);

  	Route::get('{id}/edit'	,'Vendor\ProductController@edit')
  	->name('vendor.products.edit')
    ->middleware(['permission:edit_products']);

  	Route::put('{id}'		,'Vendor\ProductController@update')
  	->name('vendor.products.update')
    ->middleware(['permission:edit_products']);

  	Route::delete('{id}'	,'Vendor\ProductController@destroy')
  	->name('vendor.products.destroy')
    ->middleware(['permission:delete_products']);

  	Route::get('deletes'	,'Vendor\ProductController@deletes')
  	->name('vendor.products.deletes')
    ->middleware(['permission:delete_products']);

  	Route::get('{id}','Vendor\ProductController@show')
  	->name('vendor.products.show')
	->middleware(['permission:show_products']);
	
	Route::get('{id}/add-ons', 'Vendor\ProductController@addOns')
        ->name('vendor.products.add_ons')
        ->middleware(['permission:add_products']);

    Route::post('{id}/store-add-ons', 'Vendor\ProductController@storeAddOns')
        ->name('vendor.products.store_add_ons')
        ->middleware(['permission:add_products']);

    Route::get('add-ons/delete', 'Vendor\ProductController@deleteAddOns')
        ->name('vendor.products.delete_add_ons')
        ->middleware(['permission:add_products']);

    Route::get('add-ons/delete/option', 'Vendor\ProductController@deleteAddOnsOption')
        ->name('vendor.products.delete_add_ons_option')
        ->middleware(['permission:add_products']);

});
