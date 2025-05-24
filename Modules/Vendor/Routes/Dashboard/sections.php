<?php

Route::group(['prefix' => 'sections', 'middleware' => 'CheckSingleVendor'], function () {

    Route::get('/', 'Dashboard\SectionController@index')
        ->name('dashboard.sections.index')
        ->middleware(['permission:show_sections']);

    Route::get('datatable', 'Dashboard\SectionController@datatable')
        ->name('dashboard.sections.datatable')
        ->middleware(['permission:show_sections']);

    Route::get('create', 'Dashboard\SectionController@create')
        ->name('dashboard.sections.create')
        ->middleware(['permission:add_sections']);

    Route::post('/', 'Dashboard\SectionController@store')
        ->name('dashboard.sections.store')
        ->middleware(['permission:add_sections']);

    Route::get('{id}/edit', 'Dashboard\SectionController@edit')
        ->name('dashboard.sections.edit')
        ->middleware(['permission:edit_sections']);

    Route::put('{id}', 'Dashboard\SectionController@update')
        ->name('dashboard.sections.update')
        ->middleware(['permission:edit_sections']);

    Route::delete('{id}', 'Dashboard\SectionController@destroy')
        ->name('dashboard.sections.destroy')
        ->middleware(['permission:delete_sections']);

    Route::get('deletes', 'Dashboard\SectionController@deletes')
        ->name('dashboard.sections.deletes')
        ->middleware(['permission:delete_sections']);

    Route::get('{id}', 'Dashboard\SectionController@show')
        ->name('dashboard.sections.show')
        ->middleware(['permission:show_sections']);
});
