<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function () {

    Route::get('/', 'Dashboard\DashboardController@index')->name('dashboard.home');
    Route::post('excel/header-row' , 'Dashboard\DashboardController@getExcelHeaderRow')->name('dashboard.excel.header.row');
});

Route::group(['prefix' => 'app-homes', 'namespace' => 'Dashboard'], function () {

    Route::get('/', 'AppHomeController@index')
        ->name('dashboard.apphomes.index')
        ->middleware(['permission:show_apphomes']);

    Route::get('datatable', 'AppHomeController@datatable')
        ->name('dashboard.apphomes.datatable')
        ->middleware(['permission:show_apphomes']);

    Route::get('create', 'AppHomeController@create')
        ->name('dashboard.apphomes.create')
        ->middleware(['permission:add_apphomes']);

    Route::post('/', 'AppHomeController@store')
        ->name('dashboard.apphomes.store')
        ->middleware(['permission:add_apphomes']);

    Route::get('{id}/edit', 'AppHomeController@edit')
        ->name('dashboard.apphomes.edit')
        ->middleware(['permission:edit_apphomes']);

    Route::put('{id}', 'AppHomeController@update')
        ->name('dashboard.apphomes.update')
        ->middleware(['permission:edit_apphomes']);

    Route::delete('{id}', 'AppHomeController@destroy')
        ->name('dashboard.apphomes.destroy')
        ->middleware(['permission:delete_apphomes']);

    Route::get('deletes', 'AppHomeController@deletes')
        ->name('dashboard.apphomes.deletes')
        ->middleware(['permission:delete_apphomes']);

    Route::get('{id}', 'AppHomeController@show')
        ->name('dashboard.apphomes.show')
        ->middleware(['permission:show_apphomes']);
});
