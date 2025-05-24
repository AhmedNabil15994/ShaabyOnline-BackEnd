<?php

Route::group(['prefix' => 'contact-us'], function () {

    Route::post('/'   , 'WebService\ContactUsController@send')->name('api.contact-us.send');

});
