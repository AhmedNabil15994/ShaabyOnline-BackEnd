<?php

view()->composer([
    'order::dashboard.orders.show',
    'order::vendor.orders.show',
    'order::dashboard.shared._filter',
    'order::vendor.shared._filter',

], \Modules\User\ViewComposers\Dashboard\DriverComposer::class);

view()->composer(['vendor::dashboard.vendors.*'], \Modules\User\ViewComposers\Dashboard\SellerComposer::class);

view()->composer([
    'coupon::dashboard.*',
    'order::dashboard.*',
    'order::vendor.*',
], \Modules\User\ViewComposers\Dashboard\UserComposer::class);

view()->composer(
    [
        'catalog::frontend.address.*',
        'catalog::frontend.address.index',
    ],
    \Modules\User\ViewComposers\FrontEnd\UserAddressesComposer::class
);
