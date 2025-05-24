<?php


Route::group(['prefix' => 'pages'], function () {

    Route::get('/'      , 'WebService\PageController@pages')->name('api.pages.index');
    Route::get('{id}'   , 'WebService\PageController@page')->name('api.pages.show');

});
