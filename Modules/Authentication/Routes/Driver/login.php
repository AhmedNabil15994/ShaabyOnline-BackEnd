<?php

Route::group(['prefix' => 'login'], function () {

    if (env('LOGIN')):

        // Show Login Form
        Route::get('/', 'Driver\LoginController@showLogin')
        ->name('driver.login')
        ->middleware('guest');

        // Submit Login
        Route::post('/', 'Driver\LoginController@postLogin')
        ->name('driver.login_post');

    endif;

});
