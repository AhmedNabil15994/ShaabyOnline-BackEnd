<?php

Route::group(['prefix' => 'vendor-categories'], function () {

    Route::get('/', 'Dashboard\CategoryController@index')
        ->name('dashboard.vendor_categories.index')
        ->middleware(['permission:show_vendor_categories']);

    Route::get('datatable', 'Dashboard\CategoryController@datatable')
        ->name('dashboard.vendor_categories.datatable')
        ->middleware(['permission:show_vendor_categories']);

    Route::get('create', 'Dashboard\CategoryController@create')
        ->name('dashboard.vendor_categories.create')
        ->middleware(['permission:add_vendor_categories']);

    Route::post('/', 'Dashboard\CategoryController@store')
        ->name('dashboard.vendor_categories.store')
        ->middleware(['permission:add_vendor_categories']);

    Route::get('{id}/edit', 'Dashboard\CategoryController@edit')
        ->name('dashboard.vendor_categories.edit')
        ->middleware(['permission:edit_vendor_categories']);

    Route::put('{id}', 'Dashboard\CategoryController@update')
        ->name('dashboard.vendor_categories.update')
        ->middleware(['permission:edit_vendor_categories']);

    Route::delete('{id}', 'Dashboard\CategoryController@destroy')
        ->name('dashboard.vendor_categories.destroy')
        ->middleware(['permission:delete_vendor_categories']);

    Route::get('deletes', 'Dashboard\CategoryController@deletes')
        ->name('dashboard.vendor_categories.deletes')
        ->middleware(['permission:delete_vendor_categories']);

    Route::get('{id}', 'Dashboard\CategoryController@show')
        ->name('dashboard.vendor_categories.show')
        ->middleware(['permission:show_vendor_categories']);

});
