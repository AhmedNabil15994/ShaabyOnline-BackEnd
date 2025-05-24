<?php

Route::group(['prefix' => 'auth'], function () {

    Route::post('login', 'WebService\LoginController@postLogin')->name('api.auth.login');
    Route::post('register', 'WebService\RegisterController@register')->name('api.auth.register');
    Route::post('forget-password', 'WebService\ForgotPasswordController@forgetPassword');
    Route::post('forget-password-for-mobile', 'WebService\ForgotPasswordController@forgetPasswordForMobile');
    Route::put('change-password-for-mobile', 'WebService\ForgotPasswordController@changePasswordForMobile');

    Route::group(['prefix' => '/', 'middleware' => 'auth:api'], function () {
        Route::post('logout', 'WebService\LoginController@logout')->name('api.auth.logout');
    });

    Route::post('resend-code', 'WebService\LoginController@resendCode')->name('api.auth.password.resend');
    Route::post('verified', 'WebService\LoginController@verified')->name('api.auth.password.verified');

});
