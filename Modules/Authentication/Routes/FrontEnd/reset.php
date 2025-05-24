<?php

Route::group(['prefix' => 'reset'], function () {

    // Show Forget Password Form
    Route::get('{token}', 'FrontEnd\ResetPasswordController@resetPassword')
    ->name('frontend.password.reset')
    ->middleware('guest');

    // Send Forget Password Via Mail
    Route::post('/', 'FrontEnd\ResetPasswordController@updatePassword')
    ->name('frontend.password.update');

});
