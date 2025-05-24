<?php

Route::group(['prefix' => 'companies'], function () {

    Route::get('/', 'Dashboard\CompanyController@index')
        ->name('dashboard.companies.index')
        ->middleware(['permission:show_companies']);

    Route::get('datatable', 'Dashboard\CompanyController@datatable')
        ->name('dashboard.companies.datatable')
        ->middleware(['permission:show_companies']);

    Route::get('create', 'Dashboard\CompanyController@create')
        ->name('dashboard.companies.create')
        ->middleware(['permission:add_companies']);

    Route::post('/', 'Dashboard\CompanyController@store')
        ->name('dashboard.companies.store')
        ->middleware(['permission:add_companies']);

    Route::get('{id}/edit', 'Dashboard\CompanyController@edit')
        ->name('dashboard.companies.edit')
        ->middleware(['permission:edit_companies']);

    Route::put('{id}', 'Dashboard\CompanyController@update')
        ->name('dashboard.companies.update')
        ->middleware(['permission:edit_companies']);

    Route::delete('{id}', 'Dashboard\CompanyController@destroy')
        ->name('dashboard.companies.destroy')
        ->middleware(['permission:delete_companies']);

    Route::get('deletes', 'Dashboard\CompanyController@deletes')
        ->name('dashboard.companies.deletes')
        ->middleware(['permission:delete_companies']);

    Route::get('{id}', 'Dashboard\CompanyController@show')
        ->name('dashboard.companies.show')
        ->middleware(['permission:show_companies']);

});
