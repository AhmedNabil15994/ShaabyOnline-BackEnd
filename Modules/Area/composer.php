<?php

view()->composer([
    'area::dashboard.cities.*',
    'order::dashboard.shared._filter',
    'order::vendor.shared._filter',
    'user::dashboard.addresses._create_modal',
], \Modules\Area\ViewComposers\Dashboard\CountryComposer::class);

view()->composer(
    [
        'area::dashboard.states.*',
        'company::dashboard.delivery-charges.*',
        'vendor::dashboard.delivery-charges.*',
        'vendor::dashboard.vendors.*',
        'order::dashboard.shared._filter',
        'order::vendor.shared._filter',
        'user::dashboard.drivers.create',
        'user::dashboard.drivers.edit',
    ],
    \Modules\Area\ViewComposers\Dashboard\CityComposer::class
);

view()->composer([
    'order::dashboard.shared._filter',
    'order::vendor.shared._filter',
], \Modules\Area\ViewComposers\Dashboard\StateComposer::class);

view()->composer(
    [
        'vendor::frontend.vendors.*',
        // 'user::frontend.profile.*',
    ],
    \Modules\Area\ViewComposers\FrontEnd\StateComposer::class
);

view()->composer(
    [
        'catalog::frontend.address.*',
        'catalog::frontend.address.index',
        'user::frontend.profile.addresses.address',
        'user::frontend.profile.addresses.create',
        'catalog::frontend.checkout.*',
    ],
    \Modules\Area\ViewComposers\FrontEnd\CityComposer::class
);

view()->composer(
    [
        'catalog::frontend.address.*',
        'catalog::frontend.address.index',
        'user::frontend.profile.addresses.address',
        'user::frontend.profile.addresses.create',
        'catalog::frontend.checkout.*',
    ],
    \Modules\Area\ViewComposers\FrontEnd\StateComposer::class
);

view()->composer(
    [
        'catalog::frontend.address.*',
        'catalog::frontend.address.index',
        'user::frontend.profile.addresses.address',
        'user::frontend.profile.addresses.create',
        'catalog::frontend.checkout.*',
    ],
    \Modules\Area\ViewComposers\FrontEnd\CountryComposer::class
);

view()->composer(
    [
        'area::dashboard.shared._area_tree',
    ],
    \Modules\Area\ViewComposers\Dashboard\AreaComposer::class
);
