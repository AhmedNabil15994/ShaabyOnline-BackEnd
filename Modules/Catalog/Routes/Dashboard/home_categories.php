<?php

Route::group(['prefix' => 'home-categories'], function () {
    Route::get('/', 'Dashboard\HomeCategoryController@index')
        ->name('dashboard.home_categories.index')
        ->middleware(['permission:show_home_categories']);

    Route::get('datatable', 'Dashboard\HomeCategoryController@datatable')
        ->name('dashboard.home_categories.datatable')
        ->middleware(['permission:show_home_categories']);

    Route::get('create', 'Dashboard\HomeCategoryController@create')
        ->name('dashboard.home_categories.create')
        ->middleware(['permission:add_home_categories']);

    Route::post('/', 'Dashboard\HomeCategoryController@store')
        ->name('dashboard.home_categories.store')
        ->middleware(['permission:add_home_categories']);

    Route::get('{id}/edit', 'Dashboard\HomeCategoryController@edit')
        ->name('dashboard.home_categories.edit')
        ->middleware(['permission:edit_home_categories']);

    Route::put('{id}', 'Dashboard\HomeCategoryController@update')
        ->name('dashboard.home_categories.update')
        ->middleware(['permission:edit_home_categories']);


    Route::delete('{id}', 'Dashboard\HomeCategoryController@destroy')
        ->name('dashboard.home_categories.destroy')
        ->middleware(['permission:delete_home_categories']);

    Route::get('deletes', 'Dashboard\HomeCategoryController@deletes')
        ->name('dashboard.home_categories.deletes')
        ->middleware(['permission:delete_home_categories']);
});
