<?php

use Modules\Catalog\Http\Middleware\CheckAddonsPermissionMiddleware;

Route::group(['prefix' => 'addon-options'], function () {

    Route::middleware([CheckAddonsPermissionMiddleware::class])->group(function () {

        Route::get('/', 'Dashboard\AddonOptionsController@index')
            ->name('dashboard.addon_options.index')
            ->middleware(['permission:show_addon_options']);

        Route::get('datatable', 'Dashboard\AddonOptionsController@datatable')
            ->name('dashboard.addon_options.datatable')
            ->middleware(['permission:show_addon_options']);

        Route::get('create', 'Dashboard\AddonOptionsController@create')
            ->name('dashboard.addon_options.create')
            ->middleware(['permission:add_addon_options']);

        Route::post('/', 'Dashboard\AddonOptionsController@store')
            ->name('dashboard.addon_options.store')
            ->middleware(['permission:add_addon_options']);

        Route::get('{id}/edit', 'Dashboard\AddonOptionsController@edit')
            ->name('dashboard.addon_options.edit')
            ->middleware(['permission:edit_addon_options']);

        Route::put('{id}', 'Dashboard\AddonOptionsController@update')
            ->name('dashboard.addon_options.update')
            ->middleware(['permission:edit_addon_options']);

        Route::delete('{id}', 'Dashboard\AddonOptionsController@destroy')
            ->name('dashboard.addon_options.destroy')
            ->middleware(['permission:delete_addon_options']);

        Route::get('deletes', 'Dashboard\AddonOptionsController@deletes')
            ->name('dashboard.addon_options.deletes')
            ->middleware(['permission:delete_addon_options']);

        Route::get('{id}', 'Dashboard\AddonOptionsController@show')
            ->name('dashboard.addon_options.show')
            ->middleware(['permission:show_addon_options']);
    });

    Route::get('addon-category/get-all', 'Dashboard\AddonOptionsController@getAddonOptionsByCategory')
        ->name('dashboard.addon_options.get_by_addon_category');

    Route::get('get-addon-details/by-product-addon-id', 'Dashboard\AddonOptionsController@getAddonDetails')
        ->name('dashboard.addon_options.get_addon_details');
});
