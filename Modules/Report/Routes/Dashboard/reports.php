<?php
Route::group(["namespace" => "Dashboard"], function () {

    Route::group(['prefix' => 'product-sales-reports'], function () {

        // product sales ========== ==============
        Route::get('/', 'ReportController@productsSale')
            ->name('dashboard.reports.product_sale')
            ->middleware(['permission:show_product_sale_reports']);

        Route::get('datatable', 'ReportController@productsSaleDataTable')
            ->name('dashboard.reports.product_sale_datatable')
            ->middleware(['permission:show_product_sale_reports']);

    });

    Route::group(['prefix' => 'order-sales-reports'], function () {

        // order sales ========== ==============
        Route::get('/', 'ReportController@ordersSale')
            ->name('dashboard.reports.order_sale')
            ->middleware(['permission:show_order_sale_reports']);

        Route::get('datatable', 'ReportController@ordersSaleDataTable')
            ->name('dashboard.reports.order_sale_datatable')
            ->middleware(['permission:show_order_sale_reports']);

    });

    Route::group(['prefix' => 'vendors-reports'], function () {

        // vendors
        Route::get('/', 'ReportController@vendorTotal')
            ->name('dashboard.reports.vendors')
            ->middleware(['permission:show_vendors_reports']);

        Route::get('datatable', 'ReportController@vendorTotalDataTable')
            ->name('dashboard.reports.vendors_datatable')
            ->middleware(['permission:show_vendors_reports']);

    });

    Route::group(['prefix' => 'product-stock-reports'], function () {

        Route::get('/', 'ReportController@productStock')
            ->name('dashboard.reports.product_stock')
            ->middleware(['permission:show_product_stock_reports']);

        Route::get('datatable', 'ReportController@productStockDataTable')
            ->name('dashboard.reports.product_stock_datatable')
            ->middleware(['permission:show_product_stock_reports']);

    });

    /*// refund product
    Route::get('/refund-products', 'ReportController@refundSale')
        ->name('dashboard.reports.refund_product')
        ->middleware(['permission:show_refund_product_reports']);

    Route::get('/refund-products/datatable', 'ReportController@refundSaleDataTable')
        ->name('dashboard.reports.product_refund_product_datatable')
        ->middleware(['permission:show_refund_product_reports']);

    // order refund ========== ==============
    Route::get('/order-refunds', 'ReportController@refundOrders')
        ->name('dashboard.reports.order_refund')
        ->middleware(['permission:show_order_refund_reports']);

    Route::get('/order-refunds/datatable', 'ReportController@ordersRefundDataTable')
        ->name('dashboard.reports.order_refund_datatable')
        ->middleware(['permission:show_order_refund_reports']);
    */

});
