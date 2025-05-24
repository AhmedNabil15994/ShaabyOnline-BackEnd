<?php

// Dashboard ViewComposr
view()->composer([
    'catalog::dashboard.categories.*',
    'catalog::dashboard.products.*',
    'advertising::dashboard.advertising.*',
    'notification::dashboard.notifications.*',
    'slider::dashboard.sliders.*',
    'coupon::dashboard.*',
], \Modules\Catalog\ViewComposers\Dashboard\CategoryComposer::class);

// Dashboard ViewComposr
view()->composer([
    'vendor::dashboard.vendors.*',
    'advertising::dashboard.advertising.*',
    'notification::dashboard.notifications.*',
    'slider::dashboard.sliders.*',
], \Modules\Catalog\ViewComposers\Dashboard\ProductComposer::class);


view()->composer([
    'coupon::dashboard.*',
], \Modules\Catalog\ViewComposers\Dashboard\ProductComposer::class);

// Vendor Dashboard ViewComposr
view()->composer([
    'catalog::vendor.categories.*',
    'catalog::vendor.products.create',
    'catalog::vendor.products.clone',
    'catalog::vendor.products.edit',
], \Modules\Catalog\ViewComposers\Vendor\CategoryComposer::class);

// FrontEnd ViewComposer
view()->composer([
    'apps::frontend.layouts.master',
], \Modules\Catalog\ViewComposers\FrontEnd\CategoryComposer::class);

// Dashboard View Composer
view()->composer([
    'catalog::dashboard.products.*',
    'catalog::vendor.products.*',
], \Modules\Catalog\ViewComposers\Dashboard\SearchKeywordComposer::class);

view()->composer([
    'catalog::dashboard.addon_options.*',
    'catalog::dashboard.products.addons',
], \Modules\Catalog\ViewComposers\Dashboard\AddonCategoryComposer::class);

view()->composer([
    'catalog::vendor.products.addons',
], \Modules\Catalog\ViewComposers\Vendor\AddonCategoryComposer::class);

// Dashboard ViewComposr
view()->composer([
    'catalog::dashboard.products.*',
    'catalog::vendor.products.*',
], \Modules\Catalog\ViewComposers\Dashboard\HomeCategoryComposer::class);
