<?php

Route::group(['prefix' => 'subscriptions', 'middleware' => 'EnableSubscriptions'], function () {

    Route::get('/', 'Dashboard\SubscriptionController@index')
        ->name('dashboard.subscriptions.index')
        ->middleware(['permission:show_subscriptions']);

    Route::get('datatable', 'Dashboard\SubscriptionController@datatable')
        ->name('dashboard.subscriptions.datatable')
        ->middleware(['permission:show_subscriptions']);

    Route::get('create', 'Dashboard\SubscriptionController@create')
        ->name('dashboard.subscriptions.create')
        ->middleware(['permission:add_subscriptions']);

    Route::post('/', 'Dashboard\SubscriptionController@store')
        ->name('dashboard.subscriptions.store')
        ->middleware(['permission:add_subscriptions']);

    Route::get('{id}/edit', 'Dashboard\SubscriptionController@edit')
        ->name('dashboard.subscriptions.edit')
        ->middleware(['permission:edit_subscriptions']);

    Route::put('{id}', 'Dashboard\SubscriptionController@update')
        ->name('dashboard.subscriptions.update')
        ->middleware(['permission:edit_subscriptions']);

    Route::delete('{id}', 'Dashboard\SubscriptionController@destroy')
        ->name('dashboard.subscriptions.destroy')
        ->middleware(['permission:delete_subscriptions']);

    Route::get('deletes', 'Dashboard\SubscriptionController@deletes')
        ->name('dashboard.subscriptions.deletes')
        ->middleware(['permission:delete_subscriptions']);

    Route::get('{id}', 'Dashboard\SubscriptionController@show')
        ->name('dashboard.subscriptions.show')
        ->middleware(['permission:show_subscriptions']);
});
