<?php

Route::group(['prefix' => 'setting'], function () {

    Route::get('/' , 'WebService\SettingController@index')->name('api.settings.index');

});
