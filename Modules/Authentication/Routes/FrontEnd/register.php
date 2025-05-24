<?php

Route::group(['prefix' => 'register'], function () {

    if (env('REGISTER')):

        // Show Register Form
        /*Route::get('/', 'FrontEnd\RegisterController@show')
        ->name('frontend.register')
        ->middleware('guest');*/

        // Submit Register
        Route::post('/', 'FrontEnd\RegisterController@register')
        ->name('frontend.register');

    endif;


});
