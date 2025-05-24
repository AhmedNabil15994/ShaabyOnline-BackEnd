<?php

Route::group(['prefix' => 'logout','middleware' => 'driver.auth'], function () {

    // Logout
    Route::any('/', 'Driver\LoginController@logout')
    ->name('driver.logout');

});
