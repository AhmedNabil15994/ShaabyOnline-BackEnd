<?php

Route::group(['prefix' => 'packages', 'middleware' => 'EnableSubscriptions'], function () {

    Route::get('/', 'Dashboard\PackageController@index')
        ->name('dashboard.packages.index')
        ->middleware(['permission:show_packages']);

    Route::get('datatable', 'Dashboard\PackageController@datatable')
        ->name('dashboard.packages.datatable')
        ->middleware(['permission:show_packages']);

    Route::get('create', 'Dashboard\PackageController@create')
        ->name('dashboard.packages.create')
        ->middleware(['permission:add_packages']);

    Route::post('/', 'Dashboard\PackageController@store')
        ->name('dashboard.packages.store')
        ->middleware(['permission:add_packages']);

    Route::get('{id}/edit', 'Dashboard\PackageController@edit')
        ->name('dashboard.packages.edit')
        ->middleware(['permission:edit_packages']);

    Route::put('{id}', 'Dashboard\PackageController@update')
        ->name('dashboard.packages.update')
        ->middleware(['permission:edit_packages']);

    Route::delete('{id}', 'Dashboard\PackageController@destroy')
        ->name('dashboard.packages.destroy')
        ->middleware(['permission:delete_packages']);

    Route::get('deletes', 'Dashboard\PackageController@deletes')
        ->name('dashboard.packages.deletes')
        ->middleware(['permission:delete_packages']);

    Route::get('{id}', 'Dashboard\PackageController@show')
        ->name('dashboard.packages.show')
        ->middleware(['permission:show_packages']);
});
