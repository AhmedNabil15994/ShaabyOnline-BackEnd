<?php

Route::group(['prefix' => 'vendors'], function () {

//    Route::get('filter', 'FrontEnd\VendorController@filter')->name('frontend.vendors.filter');
//
//    Route::get('area', 'FrontEnd\VendorController@vendorByState')->name('frontend.vendors.state');
//
//    Route::group(['prefix' => 'section'], function () {
//        Route::get('{slug}', 'FrontEnd\VendorController@vendorBySection')->name('frontend.vendors.section');
//    });

    Route::get('{slug}', 'FrontEnd\VendorController@show')->name('frontend.vendors.show');

//    Route::get('{slug}/ask-question', 'FrontEnd\VendorController@askForm')->name('frontend.vendors.ask');
//
//    Route::post('{slug}/ask-question', 'FrontEnd\VendorController@askQuestion')->name('frontend.vendors.ask');
//
//    Route::get('{slug}/prescription', 'FrontEnd\VendorController@prescriptionForm')
//        ->name('frontend.vendors.prescription');
//
//    Route::post('{slug}/prescription', 'FrontEnd\VendorController@sendPrescription')
//        ->name('frontend.vendors.prescription');

});

Route::group(['prefix' => 'vendor', 'middleware' => 'auth'], function () {
    Route::get('rate', 'FrontEnd\VendorController@vendorRate')->name('frontend.vendors.rate');
});
