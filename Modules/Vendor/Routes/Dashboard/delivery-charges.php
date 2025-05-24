<?php

Route::group(['prefix' => 'vendor-delivery-charges', 'middleware' => 'CheckVendorDelivery'], function () {

    Route::get('/', 'Dashboard\DeliveryChargeController@index')
        ->name('dashboard.vendor_delivery_charges.index')
        ->middleware(['permission:show_delivery_charges']);

    Route::get('datatable', 'Dashboard\DeliveryChargeController@datatable')
        ->name('dashboard.vendor_delivery_charges.datatable')
        ->middleware(['permission:show_delivery_charges']);

    Route::get('create', 'Dashboard\DeliveryChargeController@create')
        ->name('dashboard.vendor_delivery_charges.create')
        ->middleware(['permission:add_delivery_charges']);

    Route::post('/', 'Dashboard\DeliveryChargeController@store')
        ->name('dashboard.vendor_delivery_charges.store')
        ->middleware(['permission:add_delivery_charges']);

    Route::get('{id}/edit', 'Dashboard\DeliveryChargeController@edit')
        ->name('dashboard.vendor_delivery_charges.edit')
        ->middleware(['permission:edit_delivery_charges']);

    Route::put('{id}', 'Dashboard\DeliveryChargeController@update')
        ->name('dashboard.vendor_delivery_charges.update')
        ->middleware(['permission:edit_delivery_charges']);

    Route::delete('{id}', 'Dashboard\DeliveryChargeController@destroy')
        ->name('dashboard.vendor_delivery_charges.destroy')
        ->middleware(['permission:delete_delivery_charges']);

    Route::get('deletes', 'Dashboard\DeliveryChargeController@deletes')
        ->name('dashboard.vendor_delivery_charges.deletes')
        ->middleware(['permission:delete_delivery_charges']);

    Route::get('{id}', 'Dashboard\DeliveryChargeController@show')
        ->name('dashboard.vendor_delivery_charges.show')
        ->middleware(['permission:show_delivery_charges']);
});
