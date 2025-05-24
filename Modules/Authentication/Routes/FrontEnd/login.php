<?php

Route::group(['prefix' => 'login-signup'], function () {

    if (env('LOGIN', true)):

        // Show Login Form
        Route::get('/', 'FrontEnd\LoginController@showLogin')
        ->name('frontend.login')
        ->middleware('guest');

        // Submit Login
        Route::post('/', 'FrontEnd\LoginController@postLogin')
        ->name('frontend.post_login');

    endif;

});
