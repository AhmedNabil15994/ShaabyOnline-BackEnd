<?php

Route::group(['prefix' => 'logout','middleware' => 'auth'], function () {

    // Logout
    Route::any('/', 'FrontEnd\LoginController@logout')
    ->name('frontend.logout');

});
