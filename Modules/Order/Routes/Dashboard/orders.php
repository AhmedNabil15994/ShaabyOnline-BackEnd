<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'orders'], function () {

    Route::get('{id}/{flag}', 'Dashboard\OrderController@show')
        ->name('dashboard.orders.show')
        ->middleware(['permission:show_orders']);

    Route::put('refund/{id}', 'Dashboard\OrderController@refundOrder')
        ->name('dashboard.orders.refund')
        ->middleware(['permission:refund_order']);

    Route::put('admin-note/{id}', 'Dashboard\OrderController@updateAdminNote')
        ->name('dashboard.orders.admin.note')
        ->middleware(['permission:edit_orders']);

    Route::get('payment/confirm/{id}', 'Dashboard\OrderController@confirmPayment')
        ->name('dashboard.orders.confirm.payment')
        ->middleware(['permission:confirm_payment_order']);

    Route::get('exports/{pdf}', 'Dashboard\OrderController@export')
        ->name('dashboard.orders.export')
        ->middleware(['permission:show_orders']);
});

Route::group(['prefix' => 'current-orders'], function () {

    Route::get('/', 'Dashboard\OrderController@index')
        ->name('dashboard.current_orders.index')
        ->middleware(['permission:show_orders']);

    Route::get('datatable', 'Dashboard\OrderController@currentOrdersDatatable')
        ->name('dashboard.orders.datatable')
        ->middleware(['permission:show_orders']);

    Route::post('store', 'Dashboard\OrderController@store')
        ->name('dashboard.orders.store')
        ->middleware(['permission:add_orders']);

    Route::get('{id}/edit', 'Dashboard\OrderController@edit')
        ->name('dashboard.orders.edit')
        ->middleware(['permission:edit_orders']);

    Route::put('{id}', 'Dashboard\OrderController@update')
        ->name('dashboard.orders.update')
        ->middleware(['permission:edit_orders']);

    Route::get('bulk/update-order-status', 'Dashboard\OrderController@updateBulkOrderStatus')
        ->name('dashboard.orders.update_bulk_order_status')
        ->middleware(['permission:edit_orders']);

    Route::delete('{id}', 'Dashboard\OrderController@destroy')
        ->name('dashboard.orders.destroy')
        ->middleware(['permission:delete_orders']);

    Route::get('deletes', 'Dashboard\OrderController@deletes')
        ->name('dashboard.orders.deletes')
        ->middleware(['permission:delete_orders']);

    Route::get('print/selected-items', 'Dashboard\OrderController@printSelectedItems')
        ->name('dashboard.orders.print_selected_items')
        ->middleware(['permission:show_orders']);
});

Route::group(['prefix' => 'all-orders'], function () {

    Route::get('/', 'Dashboard\OrderController@getAllOrders')
        ->name('dashboard.all_orders.index')
        ->middleware(['permission:show_all_orders']);

    Route::get('datatable', 'Dashboard\OrderController@allOrdersDatatable')
        ->name('dashboard.all_orders.datatable')
        ->middleware(['permission:show_all_orders']);
});

Route::group(['prefix' => 'completed-orders'], function () {

    Route::get('/', 'Dashboard\OrderController@getCompletedOrders')
        ->name('dashboard.completed_orders.index')
        ->middleware(['permission:show_orders']);

    Route::get('datatable', 'Dashboard\OrderController@completedOrdersDatatable')
        ->name('dashboard.completed_orders.datatable')
        ->middleware(['permission:show_orders']);
});

Route::group(['prefix' => 'not-completed-orders'], function () {

    Route::get('/', 'Dashboard\OrderController@getNotCompletedOrders')
        ->name('dashboard.not_completed_orders.index')
        ->middleware(['permission:show_orders']);

    Route::get('datatable', 'Dashboard\OrderController@notCompletedOrdersDatatable')
        ->name('dashboard.not_completed_orders.datatable')
        ->middleware(['permission:show_orders']);
});

Route::group(['prefix' => 'refunded-orders'], function () {

    Route::get('/', 'Dashboard\OrderController@getRefundedOrders')
        ->name('dashboard.refunded_orders.index')
        ->middleware(['permission:show_orders']);

    Route::get('datatable', 'Dashboard\OrderController@refundedOrdersDatatable')
        ->name('dashboard.refunded_orders.datatable')
        ->middleware(['permission:show_orders']);
});
