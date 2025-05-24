<?php

Route::group(['prefix' => 'auth', 'namespace' => 'WebService\Auth'], function () {

    Route::post('login', 'LoginController@postLogin')->name('api.auth.drivers.login');
    Route::post('forget-password', 'ForgotPasswordController@forgetPassword')->name('api.auth.drivers.forget_password');

    Route::group(['prefix' => '/', 'middleware' => 'auth:api'], function () {
        Route::post('logout', 'LoginController@logout')->name('api.auth.drivers.logout');
    });

});
