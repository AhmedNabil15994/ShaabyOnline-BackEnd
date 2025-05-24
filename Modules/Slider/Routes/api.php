<?php


Route::group(['prefix' => 'slider'], function () {

    Route::get('/'      , 'WebService\SliderController@slider')->name('api.slider.index');

});
