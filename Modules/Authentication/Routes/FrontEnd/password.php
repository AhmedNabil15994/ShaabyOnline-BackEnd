<?php

Route::group(['prefix' => 'password'], function () {

    if (env('PASSWORD')):

        // Show Forget Password Form
        Route::get('forget', 'FrontEnd\ForgotPasswordController@forgetPassword')
        ->name('frontend.password.request')
        ->middleware('guest');

        // Send Forget Password Via Mail
        Route::post('forget', 'FrontEnd\ForgotPasswordController@sendForgetPassword')
        ->name('frontend.password.email');

    endif;

});
