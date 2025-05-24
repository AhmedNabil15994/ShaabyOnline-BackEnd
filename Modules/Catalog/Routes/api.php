<?php

Route::group(['prefix' => '/'], function () {

    Route::get('home', 'WebService\CatalogController@getHomeData')->name('api.home');
});

Route::group(['prefix' => 'catalog'], function () {

    Route::get('all-categories', 'WebService\CatalogController@getAllCategories')->name('api.categories.list');
    Route::get('products', 'WebService\CatalogController@getProductsByCategory')->name('api.products_by_category');
    Route::get('products/autocomplete', 'WebService\CatalogController@getAutoCompleteProducts')->name('api.get_autocomplete_products');
    Route::get('product/{id}/details', 'WebService\CatalogController@getProductDetails');
    Route::get('offers-products', 'WebService\CatalogController@getOffersData')->name('api.offers_products');
});

Route::group(['prefix' => 'home-categories'], function () {
    Route::get('', 'WebService\HomeCategoryController@index');
});
