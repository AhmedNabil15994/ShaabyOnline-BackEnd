<?php

Route::group(['prefix' => 'tags'], function () {

    Route::get('/', 'Dashboard\TagsController@index')
        ->name('dashboard.tags.index')
        ->middleware(['permission:show_tags']);

    Route::get('datatable', 'Dashboard\TagsController@datatable')
        ->name('dashboard.tags.datatable')
        ->middleware(['permission:show_tags']);

    Route::get('create', 'Dashboard\TagsController@create')
        ->name('dashboard.tags.create')
        ->middleware(['permission:add_tags']);

    Route::post('/', 'Dashboard\TagsController@store')
        ->name('dashboard.tags.store')
        ->middleware(['permission:add_tags']);

    Route::get('{id}/edit', 'Dashboard\TagsController@edit')
        ->name('dashboard.tags.edit')
        ->middleware(['permission:edit_tags']);

    Route::put('{id}', 'Dashboard\TagsController@update')
        ->name('dashboard.tags.update')
        ->middleware(['permission:edit_tags']);

    Route::delete('{id}', 'Dashboard\TagsController@destroy')
        ->name('dashboard.tags.destroy')
        ->middleware(['permission:delete_tags']);

    Route::get('deletes', 'Dashboard\TagsController@deletes')
        ->name('dashboard.tags.deletes')
        ->middleware(['permission:delete_tags']);

    Route::get('{id}', 'Dashboard\TagsController@show')
        ->name('dashboard.tags.show')
        ->middleware(['permission:show_tags']);

});
