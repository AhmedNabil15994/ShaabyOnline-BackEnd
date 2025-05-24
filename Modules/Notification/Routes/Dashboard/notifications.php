<?php

Route::group(['prefix' => 'notifications'], function () {

    Route::get('/', 'Dashboard\NotificationController@index')
        ->name('dashboard.notifications.index')
        ->middleware(['permission:show_notifications']);

    Route::get('datatable', 'Dashboard\NotificationController@datatable')
        ->name('dashboard.notifications.datatable')
        ->middleware(['permission:show_notifications']);

    Route::get('create', 'Dashboard\NotificationController@notifyForm')
        ->name('dashboard.notifications.create')
        ->middleware(['permission:add_notifications']);

    Route::post('send', 'Dashboard\NotificationController@push_notification')
        ->name('dashboard.notifications.store')
        ->middleware(['permission:add_notifications']);

    Route::delete('{id}', 'Dashboard\NotificationController@destroy')
        ->name('dashboard.notifications.destroy')
        ->middleware(['permission:delete_notifications']);

    Route::get('deletes', 'Dashboard\NotificationController@deletes')
        ->name('dashboard.notifications.deletes')
        ->middleware(['permission:delete_notifications']);

});
