<?php

Route::group(['prefix' => 'vendors'], function () {

    Route::group(['middleware' => 'CheckSingleVendor'], function () {

        /* Route::get('sorting', 'Dashboard\VendorController@sorting')
            ->name('dashboard.vendors.sorting')
            ->middleware(['permission:show_vendors']);

        Route::get('store/sorting', 'Dashboard\VendorController@storeSorting')
            ->name('dashboard.vendors.store.sorting')
            ->middleware(['permission:show_vendors']); */

        Route::get('/', 'Dashboard\VendorController@index')
            ->name('dashboard.vendors.index')
            ->middleware(['permission:show_vendors']);

        Route::get('datatable', 'Dashboard\VendorController@datatable')
            ->name('dashboard.vendors.datatable')
            ->middleware(['permission:show_vendors']);

        Route::get('create', 'Dashboard\VendorController@create')
            ->name('dashboard.vendors.create')
            ->middleware(['permission:add_vendors']);

        Route::post('/', 'Dashboard\VendorController@store')
            ->name('dashboard.vendors.store')
            ->middleware(['permission:add_vendors']);

        Route::get('{id}/edit', 'Dashboard\VendorController@edit')
            ->name('dashboard.vendors.edit')
            ->middleware(['permission:edit_vendors']);

        Route::put('{id}', 'Dashboard\VendorController@update')
            ->name('dashboard.vendors.update')
            ->middleware(['permission:edit_vendors']);

        Route::delete('{id}', 'Dashboard\VendorController@destroy')
            ->name('dashboard.vendors.destroy')
            ->middleware(['permission:delete_vendors']);

        Route::get('deletes', 'Dashboard\VendorController@deletes')
            ->name('dashboard.vendors.deletes')
            ->middleware(['permission:delete_vendors']);

        Route::get('{id}', 'Dashboard\VendorController@show')
            ->name('dashboard.vendors.show')
            ->middleware(['permission:show_vendors']);

        Route::get('{id}/products', 'Dashboard\VendorController@getAssignedProducts')
            ->name('dashboard.vendors.get_assigned_products')
            ->middleware(['permission:add_vendors']);

        Route::post('{id}/assign-products', 'Dashboard\VendorController@assignProducts')
            ->name('dashboard.vendors.assign_products')
            ->middleware(['permission:add_vendors']);
    });

    Route::get('active/vendors', 'Dashboard\VendorController@getAllActiveVendors')
        ->name('dashboard.vendors.get_all_active_vendors');
});
