<?php

Route::group(['prefix' => 'sellers', 'middleware' => 'CheckSingleVendor'], function () {

    Route::get('/', 'Dashboard\SellerController@index')
        ->name('dashboard.sellers.index')
        ->middleware(['permission:show_sellers']);

    Route::get('datatable', 'Dashboard\SellerController@datatable')
        ->name('dashboard.sellers.datatable')
        ->middleware(['permission:show_sellers']);

    Route::get('create', 'Dashboard\SellerController@create')
        ->name('dashboard.sellers.create')
        ->middleware(['permission:add_sellers']);

    Route::post('/', 'Dashboard\SellerController@store')
        ->name('dashboard.sellers.store')
        ->middleware(['permission:add_sellers']);

    Route::get('{id}/edit', 'Dashboard\SellerController@edit')
        ->name('dashboard.sellers.edit')
        ->middleware(['permission:edit_sellers']);

    Route::put('{id}', 'Dashboard\SellerController@update')
        ->name('dashboard.sellers.update')
        ->middleware(['permission:edit_sellers']);

    Route::delete('{id}', 'Dashboard\SellerController@destroy')
        ->name('dashboard.sellers.destroy')
        ->middleware(['permission:delete_sellers']);

    Route::get('deletes', 'Dashboard\SellerController@deletes')
        ->name('dashboard.sellers.deletes')
        ->middleware(['permission:delete_sellers']);

    Route::get('{id}', 'Dashboard\SellerController@show')
        ->name('dashboard.sellers.show')
        ->middleware(['permission:show_sellers']);

});
