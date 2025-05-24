<?php

view()->composer(
    [
        /* 'order::dashboard.orders.index',
        'order::dashboard.all_orders.index',
        'order::dashboard.completed_orders.index',
        'order::dashboard.not_completed_orders.index',
        'order::dashboard.refunded_orders.index',
        'order::vendor.orders.index',
        'order::vendor.all_orders.index',
        'order::vendor.completed_orders.index',
        'order::vendor.not_completed_orders.index',
        'order::vendor.refunded_orders.index', */

        'order::dashboard.shared._filter',
        'order::vendor.shared._filter',
        'order::dashboard.shared._bulk_order_actions',
        'order::vendor.shared._bulk_order_actions',

        'setting::dashboard.tabs.*',
    ],
    \Modules\Order\ViewComposers\Dashboard\OrderStatusComposer::class
);
