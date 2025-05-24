<?php

Route::group(['prefix' => 'states'], function () {

  	Route::get('/' ,'Dashboard\StateController@index')
  	->name('dashboard.states.index')
    ->middleware(['permission:show_states']);

  	Route::get('datatable'	,'Dashboard\StateController@datatable')
  	->name('dashboard.states.datatable')
  	->middleware(['permission:show_states']);

  	Route::get('create'		,'Dashboard\StateController@create')
  	->name('dashboard.states.create')
    ->middleware(['permission:add_states']);

  	Route::post('/'			,'Dashboard\StateController@store')
  	->name('dashboard.states.store')
    ->middleware(['permission:add_states']);

  	Route::get('{id}/edit'	,'Dashboard\StateController@edit')
  	->name('dashboard.states.edit')
    ->middleware(['permission:edit_states']);

  	Route::put('{id}'		,'Dashboard\StateController@update')
  	->name('dashboard.states.update')
    ->middleware(['permission:edit_states']);

  	Route::delete('{id}'	,'Dashboard\StateController@destroy')
  	->name('dashboard.states.destroy')
    ->middleware(['permission:delete_states']);

  	Route::get('deletes'	,'Dashboard\StateController@deletes')
  	->name('dashboard.states.deletes')
    ->middleware(['permission:delete_states']);

  	Route::get('{id}','Dashboard\StateController@show')
  	->name('dashboard.states.show')
    ->middleware(['permission:show_states']);

});
