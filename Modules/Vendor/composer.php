<?php

// DASHBOARD VIEW COMPOSER
view()->composer(['vendor::dashboard.vendors.*'], \Modules\Vendor\ViewComposers\Dashboard\PaymentComposer::class);
view()->composer(['vendor::dashboard.vendors.*'], \Modules\Vendor\ViewComposers\Dashboard\SectionComposer::class);
view()->composer(['vendor::dashboard.vendors.*', 'apps::vendor.*'], \Modules\Vendor\ViewComposers\Dashboard\VendorStatusComposer::class);

view()->composer(
    [
        'setting::dashboard.tabs.*',
        'subscription::dashboard.subscriptions.*',
        'catalog::dashboard.products.review-products.*',
        'catalog::dashboard.products.index',
        'catalog::dashboard.products.create',
        'catalog::dashboard.products.clone',
        'catalog::dashboard.products.edit',
        //  'vendor::dashboard.delivery-charges.*',
        'coupon::dashboard.*',

        /* 'order::dashboard.orders.index',
        'order::dashboard.all_orders.index',
        'order::dashboard.completed_orders.index',
        'order::dashboard.not_completed_orders.index',
        'order::dashboard.refunded_orders.index', */

        'order::dashboard.shared._filter',
        'order::vendor.shared._filter',

        "report::dashboard.reports.*",
        "slider::dashboard.sliders.create",
        "slider::dashboard.sliders.edit",

        'advertising::dashboard.advertising.create',
        'advertising::dashboard.advertising.edit',
    ],
    \Modules\Vendor\ViewComposers\Dashboard\VendorComposer::class
);

view()->composer(
    [
        'vendor::frontend.vendors.sidebar.filter'
    ],
    \Modules\Vendor\ViewComposers\FrontEnd\PaymentsComposer::class
);

view()->composer(
    [
        'vendor::frontend.vendors.sidebar.filter',
    ],
    \Modules\Vendor\ViewComposers\FrontEnd\VendorStatusComposer::class
);

// VENDOR DASHBOARD VIEW COMPOSER
view()->composer(['apps::vendor.index'], \Modules\Vendor\ViewComposers\Vendor\VendorComposer::class);

view()->composer(
    [
        'catalog::vendor.products.create',
        'catalog::vendor.products.edit',
        'catalog::vendor.products.clone',
    ],
    \Modules\Vendor\ViewComposers\Vendor\VendorComposer::class
);

// Dashboard ViewComposer
view()->composer([
    'vendor::dashboard.categories.*',
    'vendor::dashboard.vendors.*',
    /*'advertising::dashboard.advertising.*',
    'notification::dashboard.notifications.*',
    'slider::dashboard.sliders.*',
    'coupon::dashboard.*',*/
], \Modules\Vendor\ViewComposers\Dashboard\CategoryComposer::class);
