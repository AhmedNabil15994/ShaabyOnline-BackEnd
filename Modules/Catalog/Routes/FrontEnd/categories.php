<?php

/* Route::get('categories', 'FrontEnd\CategoryController@index')
    ->name('frontend.categories.index'); */

Route::get('category/{slug?}', 'FrontEnd\CategoryController@productsCategory')
    ->name('frontend.categories.products');
