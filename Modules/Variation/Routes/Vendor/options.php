<?php

Route::group(['prefix' => 'options'], function () {

    Route::get('values-by-option-id' ,'Vendor\OptionController@valuesByOptionId')
    ->name('vendor.values_by_option_id');

});
