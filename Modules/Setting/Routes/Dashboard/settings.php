<?php

Route::group(['prefix' => 'setting', 'middleware' => ['tocaan.user']], function () {

    // Show Settings Form
    Route::get('/', 'Dashboard\SettingController@index')
        ->name('dashboard.setting.index');

    // Update Settings
    Route::post('/', 'Dashboard\SettingController@update')
        ->name('dashboard.setting.update');
});
