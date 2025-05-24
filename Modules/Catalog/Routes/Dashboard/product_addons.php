<?php

Route::group(['prefix' => 'products'], function () {

    Route::get('{id}/add-ons', 'Dashboard\ProductAddonsController@addOns')
        ->name('dashboard.products.add_ons')
        ->middleware(['permission:show_product_addons']);

    Route::post('{id}/store-add-ons', 'Dashboard\ProductAddonsController@storeAddOns')
        ->name('dashboard.products.store_add_ons')
        ->middleware(['permission:show_product_addons']);

    Route::get('add-ons/delete', 'Dashboard\ProductAddonsController@deleteAddOns')
        ->name('dashboard.products.delete_add_ons')
        ->middleware(['permission:show_product_addons']);

    Route::get('add-ons/delete/option', 'Dashboard\ProductAddonsController@deleteAddOnsOption')
        ->name('dashboard.products.delete_add_ons_option')
        ->middleware(['permission:show_product_addons']);
});
