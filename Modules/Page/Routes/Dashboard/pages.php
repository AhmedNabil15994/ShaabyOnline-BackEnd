<?php

Route::group(['prefix' => 'pages'], function () {

  	Route::get('/' ,'Dashboard\PageController@index')
  	->name('dashboard.pages.index')
    ->middleware(['permission:show_pages']);

  	Route::get('datatable'	,'Dashboard\PageController@datatable')
  	->name('dashboard.pages.datatable')
  	->middleware(['permission:show_pages']);

  	Route::get('create'		,'Dashboard\PageController@create')
  	->name('dashboard.pages.create')
    ->middleware(['permission:add_pages']);

  	Route::post('/'			,'Dashboard\PageController@store')
  	->name('dashboard.pages.store')
    ->middleware(['permission:add_pages']);

  	Route::get('{id}/edit'	,'Dashboard\PageController@edit')
  	->name('dashboard.pages.edit')
    ->middleware(['permission:edit_pages']);

  	Route::put('{id}'		,'Dashboard\PageController@update')
  	->name('dashboard.pages.update')
    ->middleware(['permission:edit_pages']);

  	Route::delete('{id}'	,'Dashboard\PageController@destroy')
  	->name('dashboard.pages.destroy')
    ->middleware(['permission:delete_pages']);

  	Route::get('deletes'	,'Dashboard\PageController@deletes')
  	->name('dashboard.pages.deletes')
    ->middleware(['permission:delete_pages']);

  	Route::get('{id}','Dashboard\PageController@show')
  	->name('dashboard.pages.show')
    ->middleware(['permission:show_pages']);

});
