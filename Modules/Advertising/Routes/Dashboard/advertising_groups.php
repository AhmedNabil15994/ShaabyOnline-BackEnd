<?php

Route::group(['prefix' => 'advertising-groups'], function () {

    Route::get('/', 'Dashboard\AdvertisingGroupController@index')
        ->name('dashboard.advertising_groups.index')
        ->middleware(['permission:show_advertising']);

    Route::get('datatable', 'Dashboard\AdvertisingGroupController@datatable')
        ->name('dashboard.advertising_groups.datatable')
        ->middleware(['permission:show_advertising']);

    Route::get('create', 'Dashboard\AdvertisingGroupController@create')
        ->name('dashboard.advertising_groups.create')
        ->middleware(['permission:add_advertising']);

    Route::post('/', 'Dashboard\AdvertisingGroupController@store')
        ->name('dashboard.advertising_groups.store')
        ->middleware(['permission:add_advertising']);

    Route::get('{id}/edit', 'Dashboard\AdvertisingGroupController@edit')
        ->name('dashboard.advertising_groups.edit')
        ->middleware(['permission:edit_advertising']);

    Route::put('{id}', 'Dashboard\AdvertisingGroupController@update')
        ->name('dashboard.advertising_groups.update')
        ->middleware(['permission:edit_advertising']);

    Route::delete('{id}', 'Dashboard\AdvertisingGroupController@destroy')
        ->name('dashboard.advertising_groups.destroy')
        ->middleware(['permission:delete_advertising']);

    Route::get('deletes', 'Dashboard\AdvertisingGroupController@deletes')
        ->name('dashboard.advertising_groups.deletes')
        ->middleware(['permission:delete_advertising']);

    Route::get('{id}', 'Dashboard\AdvertisingGroupController@show')
        ->name('dashboard.advertising_groups.show')
        ->middleware(['permission:show_advertising']);

    Route::get('change/status', 'Dashboard\AdvertisingGroupController@changeAdvertGroupStatus')
        ->name('dashboard.advertising_groups.change_advert_group_status');

});
