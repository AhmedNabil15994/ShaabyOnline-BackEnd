<?php

Route::group(['prefix' => 'slider'], function () {

  	Route::get('/' ,'Dashboard\SliderController@index')
  	->name('dashboard.slider.index')
    ->middleware(['permission:show_slider']);

    Route::get('datatable'	,'Dashboard\SliderController@datatable')
    ->name('dashboard.slider.datatable')
    ->middleware(['permission:show_slider']);

  	Route::get('create'		,'Dashboard\SliderController@create')
  	->name('dashboard.slider.create')
    ->middleware(['permission:add_slider']);

  	Route::post('/'			,'Dashboard\SliderController@store')
  	->name('dashboard.slider.store')
    ->middleware(['permission:add_slider']);

  	Route::get('{id}/edit'	,'Dashboard\SliderController@edit')
  	->name('dashboard.slider.edit')
    ->middleware(['permission:edit_slider']);

  	Route::put('{id}'		,'Dashboard\SliderController@update')
  	->name('dashboard.slider.update')
    ->middleware(['permission:edit_slider']);

  	Route::delete('{id}'	,'Dashboard\SliderController@destroy')
  	->name('dashboard.slider.destroy')
    ->middleware(['permission:delete_slider']);

  	Route::get('deletes'	,'Dashboard\SliderController@deletes')
  	->name('dashboard.slider.deletes')
    ->middleware(['permission:delete_slider']);

  	Route::get('{id}','Dashboard\SliderController@show')
  	->name('dashboard.slider.show')
    ->middleware(['permission:show_slider']);

});
