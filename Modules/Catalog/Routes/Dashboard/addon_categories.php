<?php

Route::group(['prefix' => 'addon-categories', 'middleware' => 'CheckAddonsPermission'], function () {

    Route::get('/', 'Dashboard\AddonCategoryController@index')
        ->name('dashboard.addon_categories.index')
        ->middleware(['permission:show_addon_categories']);

    Route::get('datatable', 'Dashboard\AddonCategoryController@datatable')
        ->name('dashboard.addon_categories.datatable')
        ->middleware(['permission:show_addon_categories']);

    Route::get('create', 'Dashboard\AddonCategoryController@create')
        ->name('dashboard.addon_categories.create')
        ->middleware(['permission:add_addon_categories']);

    Route::post('/', 'Dashboard\AddonCategoryController@store')
        ->name('dashboard.addon_categories.store')
        ->middleware(['permission:add_addon_categories']);

    Route::get('{id}/edit', 'Dashboard\AddonCategoryController@edit')
        ->name('dashboard.addon_categories.edit')
        ->middleware(['permission:edit_addon_categories']);

    Route::put('{id}', 'Dashboard\AddonCategoryController@update')
        ->name('dashboard.addon_categories.update')
        ->middleware(['permission:edit_addon_categories']);

    Route::delete('{id}', 'Dashboard\AddonCategoryController@destroy')
        ->name('dashboard.addon_categories.destroy')
        ->middleware(['permission:delete_addon_categories']);

    Route::get('deletes', 'Dashboard\AddonCategoryController@deletes')
        ->name('dashboard.addon_categories.deletes')
        ->middleware(['permission:delete_addon_categories']);

    Route::get('{id}', 'Dashboard\AddonCategoryController@show')
        ->name('dashboard.addon_categories.show')
        ->middleware(['permission:show_addon_categories']);

});
