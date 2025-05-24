<?php


Route::group(['prefix' => 'user', 'middleware' => 'auth:api'], function () {

    Route::get('profile', 'WebService\UserController@profile')->name('api.users.profile');
    Route::put('profile', 'WebService\UserController@updateProfile')->name('api.users.profile_save');
    Route::put('change-password', 'WebService\UserController@changePassword');
    Route::post('get-verified', 'WebService\UserController@getVerifidCode');
    Route::delete('delete-account', 'WebService\UserController@deleteUserAccount')->name('api.users.delete_account');
});

Route::group(['prefix' => 'address', 'middleware' => 'auth:api'], function () {

    Route::get('list', 'WebService\UserAddressController@list')->name('api.address.list');
    Route::get('{id}/get', 'WebService\UserAddressController@getAddressById')->name('api.address.get_by_id');
    Route::get('edit/{id}', 'WebService\UserAddressController@edit')->name('api.address.edit');
    Route::post('update/{id}', 'WebService\UserAddressController@update')->name('api.address.update');
    Route::post('delete/{id}', 'WebService\UserAddressController@delete')->name('api.address.delete');
    Route::post('create', 'WebService\UserAddressController@create')->name('api.address.create');
    Route::post('make-default/{id}', 'WebService\UserAddressController@makeDefaultAddress')->name('api.address.make_default');
});

Route::group(['prefix' => 'favourites', 'middleware' => 'auth:api'], function () {

    Route::get('list', 'WebService\UserFavouritesController@list')->name('api.favourites.list');
    Route::post('store', 'WebService\UserFavouritesController@store')->name('api.favourites.store');
    Route::post('delete/{id}', 'WebService\UserFavouritesController@delete')->name('api.favourites.delete');
});

Route::group(['prefix' => 'user-firebase-tokens'/*, 'middleware' => ['auth:api']*/], function () {
    Route::post('/', 'WebService\UserFirebaseTokenController@store');
});
