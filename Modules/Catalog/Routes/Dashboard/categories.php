<?php

Route::group(['prefix' => 'categories'], function () {

	Route::get('/', 'Dashboard\CategoryController@index')
		->name('dashboard.categories.index')
		->middleware(['permission:show_categories']);

	Route::get('datatable', 'Dashboard\CategoryController@datatable')
		->name('dashboard.categories.datatable')
		->middleware(['permission:show_categories']);

	Route::get('create', 'Dashboard\CategoryController@create')
		->name('dashboard.categories.create')
		->middleware(['permission:add_categories']);

		//import excel
	Route::post('import', 'Dashboard\CategoryController@Import')
		->name('dashboard.categories.import.excel')
		->middleware(['permission:add_categories']);

	Route::post('/', 'Dashboard\CategoryController@store')
		->name('dashboard.categories.store')
		->middleware(['permission:add_categories']);

	Route::get('{id}/edit', 'Dashboard\CategoryController@edit')
		->name('dashboard.categories.edit')
		->middleware(['permission:edit_categories']);

	Route::put('{id}', 'Dashboard\CategoryController@update')
		->name('dashboard.categories.update')
		->middleware(['permission:edit_categories']);

	Route::delete('{id}', 'Dashboard\CategoryController@destroy')
		->name('dashboard.categories.destroy')
		->middleware(['permission:delete_categories']);

	Route::get('deletes', 'Dashboard\CategoryController@deletes')
		->name('dashboard.categories.deletes')
		->middleware(['permission:delete_categories']);

	Route::get('{id}', 'Dashboard\CategoryController@show')
		->name('dashboard.categories.show')
		->middleware(['permission:show_categories']);

	Route::post('/update/photo', 'Dashboard\CategoryController@updatePhoto')
		->name('dashboard.categories.update.photo')
		->middleware(['permission:edit_categories']);
});
