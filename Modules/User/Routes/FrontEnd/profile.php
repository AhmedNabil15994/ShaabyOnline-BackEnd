<?php

Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function () {

    Route::get('/', 'FrontEnd\UserController@index')
        ->name('frontend.profile.index');

    Route::post('/', 'FrontEnd\UserController@updateProfile')
        ->name('frontend.profile.update');

    Route::group(['prefix' => 'addresses'], function () {

        Route::get('/', 'FrontEnd\UserController@addresses')
            ->name('frontend.profile.address.index');

        Route::get('create', 'FrontEnd\UserController@createAddress')
            ->name('frontend.profile.address.create');

        Route::post('store', 'FrontEnd\UserController@storeAddress')
            ->name('frontend.profile.address.store');

        Route::get('{id}', 'FrontEnd\UserController@editAddress')
            ->name('frontend.profile.address.edit');

        Route::post('{id}', 'FrontEnd\UserController@updateAddress')
            ->name('frontend.profile.address.update');

        Route::get('delete/{id}', 'FrontEnd\UserController@deleteAddress')
            ->name('frontend.profile.address.delete');

    });

    Route::group(['prefix' => 'favourites'], function () {

        Route::get('/', 'FrontEnd\UserController@favourites')
            ->name('frontend.profile.favourites.index');

        Route::post('store/{prdId}', 'FrontEnd\UserController@storeFavourite')
            ->name('frontend.profile.favourites.store');

        Route::get('delete/{prdId}', 'FrontEnd\UserController@deleteFavourite')
            ->name('frontend.profile.favourites.delete');
    });

});
