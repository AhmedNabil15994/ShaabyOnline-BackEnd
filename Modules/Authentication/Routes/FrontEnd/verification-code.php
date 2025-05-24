<?php

Route::group(['prefix' => 'verification-code'], function () {

    Route::get('/', 'FrontEnd\VerificationCodeController@getVerificationCode')
        ->name('frontend.get_verification_code');

    Route::post('check', 'FrontEnd\VerificationCodeController@checkVerificationCode')
        ->name('frontend.check_verification_code');

});
