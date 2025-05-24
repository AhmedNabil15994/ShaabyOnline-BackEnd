<?php

Route::group(['prefix' => 'p'], function () {

    Route::get('{slug}', 'FrontEnd\PageController@page')->name('frontend.pages.index');

});
