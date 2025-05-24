<?php

Route::group(['prefix' => 'login'], function () {

    if (env('LOGIN', true)):

        // Show Login Form
        Route::get('/', 'Vendor\LoginController@showLogin')
        ->name('vendor.login')
        ->middleware('guest');

        // Submit Login
        Route::post('/', 'Vendor\LoginController@postLogin')
        ->name('vendor.login_post');

    endif;

});
