<?php

Route::group(['prefix' => 'options'], function () {

    Route::get('values-by-option-id' ,'Dashboard\OptionController@valuesByOptionId')
    ->name('dashboard.values_by_option_id')
    ->middleware(['permission:show_options']);

  	Route::get('/' ,'Dashboard\OptionController@index')
  	->name('dashboard.options.index')
    ->middleware(['permission:show_options']);

  	Route::get('datatable'	,'Dashboard\OptionController@datatable')
  	->name('dashboard.options.datatable')
  	->middleware(['permission:show_options']);

  	Route::get('create'		,'Dashboard\OptionController@create')
  	->name('dashboard.options.create')
    ->middleware(['permission:add_options']);

  	Route::post('/'			,'Dashboard\OptionController@store')
  	->name('dashboard.options.store')
    ->middleware(['permission:add_options']);

  	Route::get('{id}/edit'	,'Dashboard\OptionController@edit')
  	->name('dashboard.options.edit')
    ->middleware(['permission:edit_options']);

  	Route::put('{id}'		,'Dashboard\OptionController@update')
  	->name('dashboard.options.update')
    ->middleware(['permission:edit_options']);

  	Route::delete('{id}'	,'Dashboard\OptionController@destroy')
  	->name('dashboard.options.destroy')
    ->middleware(['permission:delete_options']);

  	Route::get('deletes'	,'Dashboard\OptionController@deletes')
  	->name('dashboard.options.deletes')
    ->middleware(['permission:delete_options']);

  	Route::get('{id}','Dashboard\OptionController@show')
  	->name('dashboard.options.show')
    ->middleware(['permission:show_options']);

});
