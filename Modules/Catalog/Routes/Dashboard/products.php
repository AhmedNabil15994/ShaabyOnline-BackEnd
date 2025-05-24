<?php

Route::group(['prefix' => 'products'], function () {

    Route::get('/', 'Dashboard\ProductController@index')
        ->name('dashboard.products.index')
        ->middleware(['permission:show_products']);

    Route::get('datatable', 'Dashboard\ProductController@datatable')
        ->name('dashboard.products.datatable')
        ->middleware(['permission:show_products']);

    Route::get('create', 'Dashboard\ProductController@create')
        ->name('dashboard.products.create')
        ->middleware(['permission:add_products']);
	
    Route::post('import/photos' , 'Dashboard\ProductController@importPhoto')
    ->name('dashboard.products.store.multi.photo')
    ->middleware(['permission:add_products']);
    
    //import excel
    Route::post('import', 'Dashboard\ProductController@Import')
        ->name('dashboard.products.import.excel')
        ->middleware(['permission:add_products']);

    Route::post('/', 'Dashboard\ProductController@store')
        ->name('dashboard.products.store')
        ->middleware(['permission:add_products']);

    Route::get('{id}/edit', 'Dashboard\ProductController@edit')
        ->name('dashboard.products.edit')
        ->middleware(['permission:edit_products']);

    Route::put('{id}', 'Dashboard\ProductController@update')
        ->name('dashboard.products.update')
        ->middleware(['permission:edit_products']);

    Route::get('{id}/clone', 'Dashboard\ProductController@clone')
        ->name('dashboard.products.clone')
        ->middleware(['permission:add_products']);

    Route::delete('{id}', 'Dashboard\ProductController@destroy')
        ->name('dashboard.products.destroy')
        ->middleware(['permission:delete_products']);

    Route::get('deletes', 'Dashboard\ProductController@deletes')
        ->name('dashboard.products.deletes')
        ->middleware(['permission:delete_products']);

    Route::get('{id}', 'Dashboard\ProductController@show')
        ->name('dashboard.products.show')
        ->middleware(['permission:show_products']);

    Route::get('product/delete/image', 'Dashboard\ProductController@deleteProductImage')
        ->name('dashboard.products.delete_product_image')
        ->middleware(['permission:edit_products']);

    Route::post('/update/photo', 'Dashboard\ProductController@updatePhoto')
        ->name('dashboard.products.update.photo')
        ->middleware(['permission:edit_products']);
});

Route::group(['prefix' => 'review-products'], function () {

    ### START - Review Products Routes ###
    Route::get('/', 'Dashboard\ProductController@reviewProducts')
        ->name('dashboard.review_products.index')
        ->middleware(['permission:review_products']);

    Route::get('datatable', 'Dashboard\ProductController@reviewProductsDatatable')
        ->name('dashboard.review_products.datatable')
        ->middleware(['permission:review_products']);

    Route::post('approve-product/{id}', 'Dashboard\ProductController@approveProduct')
        ->name('dashboard.review_products.approve_product')
        ->middleware(['permission:review_products']);
    ### END - Review Products Routes ###

});
