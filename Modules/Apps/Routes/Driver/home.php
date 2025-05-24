<?php

Route::prefix('/')->group(function() {

    Route::get('/' , 'Driver\DriverController@index')->name('driver.home');

});
