<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'orders'], function () {
    Route::get('{id}/{flag}', 'Vendor\OrderController@show')
        ->name('vendor.orders.show')
        ->middleware(['permission:show_orders']);

    Route::put('refund/{id}', 'Vendor\OrderController@refundOrder')
        ->name('vendor.orders.refund')
        ->middleware(['permission:refund_order']);

    Route::put('admin-note/{id}', 'Vendor\OrderController@updateAdminNote')
        ->name('vendor.orders.admin.note')
        ->middleware(['permission:edit_orders']);

    Route::get('payment/confirm/{id}', 'Vendor\OrderController@confirmPayment')
        ->name('vendor.orders.confirm.payment')
        ->middleware(['permission:confirm_payment_order']);

    Route::get('exports/{pdf}', 'Vendor\OrderController@export')
        ->name('vendor.orders.export')
        ->middleware(['permission:show_orders']);
});

Route::group(['prefix' => 'current-orders'], function () {

    Route::get('/', 'Vendor\OrderController@index')
        ->name('vendor.current_orders.index')
        ->middleware(['permission:show_orders']);

    Route::get('datatable', 'Vendor\OrderController@currentOrdersDatatable')
        ->name('vendor.orders.datatable')
        ->middleware(['permission:show_orders']);

    Route::post('store', 'Vendor\OrderController@store')
        ->name('vendor.orders.store')
        ->middleware(['permission:add_orders']);

    Route::get('{id}/edit', 'Vendor\OrderController@edit')
        ->name('vendor.orders.edit')
        ->middleware(['permission:edit_orders']);

    Route::put('{id}', 'Vendor\OrderController@update')
        ->name('vendor.orders.update')
        ->middleware(['permission:edit_orders']);

    Route::get('bulk/update-order-status', 'Vendor\OrderController@updateBulkOrderStatus')
        ->name('vendor.orders.update_bulk_order_status')
        ->middleware(['permission:edit_orders']);

    Route::delete('{id}', 'Vendor\OrderController@destroy')
        ->name('vendor.orders.destroy')
        ->middleware(['permission:delete_orders']);

    Route::get('deletes', 'Vendor\OrderController@deletes')
        ->name('vendor.orders.deletes')
        ->middleware(['permission:delete_orders']);

    Route::get('print/selected-items', 'Vendor\OrderController@printSelectedItems')
        ->name('vendor.orders.print_selected_items')
        ->middleware(['permission:show_orders']);
});

Route::group(['prefix' => 'all-orders'], function () {

    Route::get('/', 'Vendor\OrderController@getAllOrders')
        ->name('vendor.all_orders.index')
        ->middleware(['permission:show_all_orders']);

    Route::get('datatable', 'Vendor\OrderController@allOrdersDatatable')
        ->name('vendor.all_orders.datatable')
        ->middleware(['permission:show_all_orders']);
});

Route::group(['prefix' => 'completed-orders'], function () {

    Route::get('/', 'Vendor\OrderController@getCompletedOrders')
        ->name('vendor.completed_orders.index')
        ->middleware(['permission:show_orders']);

    Route::get('datatable', 'Vendor\OrderController@completedOrdersDatatable')
        ->name('vendor.completed_orders.datatable')
        ->middleware(['permission:show_orders']);
});

Route::group(['prefix' => 'not-completed-orders'], function () {

    Route::get('/', 'Vendor\OrderController@getNotCompletedOrders')
        ->name('vendor.not_completed_orders.index')
        ->middleware(['permission:show_orders']);

    Route::get('datatable', 'Vendor\OrderController@notCompletedOrdersDatatable')
        ->name('vendor.not_completed_orders.datatable')
        ->middleware(['permission:show_orders']);
});

Route::group(['prefix' => 'refunded-orders'], function () {

    Route::get('/', 'Vendor\OrderController@getRefundedOrders')
        ->name('vendor.refunded_orders.index')
        ->middleware(['permission:show_orders']);

    Route::get('datatable', 'Vendor\OrderController@refundedOrdersDatatable')
        ->name('vendor.refunded_orders.datatable')
        ->middleware(['permission:show_orders']);
});
