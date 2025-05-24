<?php

Route::prefix('/')->group(function() {

    Route::get('/' , 'Vendor\VendorController@index')->name('vendor.home');
    // Route::get('/edit-vendor-info/{id}' , 'Vendor\VendorController@editVendorInfo')->name('vendor.edit.info');
    Route::post('/update-vendor-info/{id}' , 'Vendor\VendorController@updateVendorInfo')->name('vendor.update.info');

});
