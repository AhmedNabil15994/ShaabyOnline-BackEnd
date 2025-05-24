<?php


Route::group(['prefix' => 'vendors'], function () {
    Route::get('delivery-charge', 'WebService\VendorController@deliveryCharge');
    Route::get('sections', 'WebService\VendorController@sections');
    Route::get('categories', 'WebService\VendorController@getCategories')->name('api.vendors.categories');
    Route::get('/', 'WebService\VendorController@vendors');
    Route::get('/{id}', 'WebService\VendorController@getVendorById')->name('get_one_vendor');
    Route::get('vendor/delivery-times', 'WebService\VendorController@getVendorDeliveryTimes')->name('api.get_vendor_delivery_times');
    Route::group(['prefix' => '/', 'middleware' => 'auth:api'], function () {

        Route::post('rate', 'WebService\VendorController@vendorRate')->name('api.vendors.rate');
    });
});
