<?php

Route::group(['prefix' => 'shopping-cart'], function () {

    Route::get('/', 'FrontEnd\ShoppingCartController@index')
        ->name('frontend.shopping-cart.index');

    Route::get('delete/{id}', 'FrontEnd\ShoppingCartController@delete')
        ->name('frontend.shopping-cart.delete');

    Route::get('deleteByAjax', 'FrontEnd\ShoppingCartController@deleteByAjax')
        ->name('frontend.shopping-cart.deleteByAjax');

    Route::get('clear', 'FrontEnd\ShoppingCartController@clear')
        ->name('frontend.shopping-cart.clear');

//    Route::get('header' ,'FrontEnd\ShoppingCartController@headerCart')
//  	->name('frontend.shopping-cart.header');

    Route::get('total', 'FrontEnd\ShoppingCartController@totalCart')
        ->name('frontend.shopping-cart.total');

    /*Route::post('{product}/{vendor}', 'FrontEnd\ShoppingCartController@createOrUpdate')
        ->name('frontend.shopping-cart.create-or-update');*/

    Route::post('{product?}/{variantPrdId?}', 'FrontEnd\ShoppingCartController@createOrUpdate')
        ->name('frontend.shopping-cart.create-or-update');


    Route::group(['prefix' => 'gift'], function () {

        Route::post('/add-gift/{id}', 'FrontEnd\ShoppingCartController@addGiftToCart')
            ->name('frontend.shopping-cart.add_gift');

        Route::post('/remove-cart-gift/{id}', 'FrontEnd\ShoppingCartController@removeCartGift')
            ->name('frontend.shopping-cart.remove_cart_gift');

    });

    Route::group(['prefix' => 'card'], function () {

        Route::post('/add-cart-card/{id}', 'FrontEnd\ShoppingCartController@addOrUpdateCartCard')
            ->name('frontend.shopping-cart.add_card');

        Route::post('/remove-cart-card/{id}', 'FrontEnd\ShoppingCartController@removeCartCard')
            ->name('frontend.shopping-cart.remove_cart_card');

    });

    Route::group(['prefix' => 'addons'], function () {

        Route::post('/add-cart-addons/{id}', 'FrontEnd\ShoppingCartController@addOrUpdateCartAddons')
            ->name('frontend.shopping-cart.add_addons');

        Route::post('/remove-cart-addons/{id}', 'FrontEnd\ShoppingCartController@removeCartAddons')
            ->name('frontend.shopping-cart.remove_cart_addons');

    });

});
