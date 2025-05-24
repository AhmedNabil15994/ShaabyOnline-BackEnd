<?php

Route::group(['prefix' => 'user', 'middleware' => 'auth:api', 'namespace' => 'WebService\Auth'], function () {

    Route::get('profile', 'UserController@profile')->name('api.drivers.users.profile');
    Route::put('profile', 'UserController@updateProfile')->name('api.drivers.users.profile');
    Route::put('change-password', 'UserController@changePassword')->name('api.drivers.users.change_password');

});
