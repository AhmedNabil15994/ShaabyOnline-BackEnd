<?php

Route::group(['prefix' => 'logout','middleware' => 'vendor.auth'], function () {

    // Logout
    Route::any('/', 'Vendor\LoginController@logout')
    ->name('vendor.logout');

});
