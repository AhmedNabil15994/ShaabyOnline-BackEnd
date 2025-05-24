<?php

Route::group(['prefix' => 'search-keywords'], function () {

    Route::get('/', 'Dashboard\SearchKeywordsController@index')
        ->name('dashboard.search_keywords.index')
        ->middleware(['permission:show_search_keywords']);

    Route::get('datatable', 'Dashboard\SearchKeywordsController@datatable')
        ->name('dashboard.search_keywords.datatable')
        ->middleware(['permission:show_search_keywords']);

    Route::get('create', 'Dashboard\SearchKeywordsController@create')
        ->name('dashboard.search_keywords.create')
        ->middleware(['permission:add_search_keywords']);

    Route::post('/', 'Dashboard\SearchKeywordsController@store')
        ->name('dashboard.search_keywords.store')
        ->middleware(['permission:add_search_keywords']);

    Route::get('{id}/edit', 'Dashboard\SearchKeywordsController@edit')
        ->name('dashboard.search_keywords.edit')
        ->middleware(['permission:edit_search_keywords']);

    Route::put('{id}', 'Dashboard\SearchKeywordsController@update')
        ->name('dashboard.search_keywords.update')
        ->middleware(['permission:edit_search_keywords']);

    Route::delete('{id}', 'Dashboard\SearchKeywordsController@destroy')
        ->name('dashboard.search_keywords.destroy')
        ->middleware(['permission:delete_search_keywords']);

    Route::get('deletes', 'Dashboard\SearchKeywordsController@deletes')
        ->name('dashboard.search_keywords.deletes')
        ->middleware(['permission:delete_search_keywords']);

    Route::get('{id}', 'Dashboard\SearchKeywordsController@show')
        ->name('dashboard.search_keywords.show')
        ->middleware(['permission:show_search_keywords']);

});
