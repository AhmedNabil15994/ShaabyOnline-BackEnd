<?php

Route::group(['prefix' => 'logout','middleware' => 'dashboard.auth'], function () {

    // Logout
    Route::any('/', 'Dashboard\LoginController@logout')
    ->name('dashboard.logout');

});
