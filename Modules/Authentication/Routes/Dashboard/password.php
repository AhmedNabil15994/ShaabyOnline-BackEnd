<?php

Route::group(['prefix' => 'password'], function () {

    // Show Forget Password Form
    Route::get('forget', 'Dashboard\ForgotPasswordController@forgetPassword')
        ->name('dashboard.password.request')
        ->middleware('guest');

    // Send Forget Password Via Mail
    Route::post('forget', 'Dashboard\ForgotPasswordController@sendForgetPassword')
        ->name('dashboard.password.email');
});

Route::group(['prefix' => 'reset'], function () {

    // Show Forget Password Form
    Route::get('{token}', 'Dashboard\ResetPasswordController@resetPassword')
        ->name('dashboard.password.reset')
        ->middleware('guest');

    // Send Forget Password Via Mail
    Route::post('/', 'Dashboard\ResetPasswordController@updatePassword')
        ->name('dashboard.password.update');
});
