<?php


Route::group(['prefix' => 'advertising'], function () {

    Route::get('/'      , 'WebService\AdvertisingController@advertising')->name('api.advertising.index');

});
