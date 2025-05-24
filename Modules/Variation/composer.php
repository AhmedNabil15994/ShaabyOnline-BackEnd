<?php

// DASHBOARD VIEW COMPOSER
view()->composer([
  'catalog::dashboard.products.create',
  'catalog::dashboard.products.clone',
  'catalog::dashboard.products.edit',
], \Modules\Variation\ViewComposers\Dashboard\OptionComposer::class);


view()->composer([
  'catalog::dashboard.products.html.tabs_variation_blank'
], \Modules\Variation\ViewComposers\Dashboard\FindOptionValuesComposer::class);


// Vendor VIEW COMPOSER
view()->composer([
  'catalog::vendor.products.create',
  'catalog::vendor.products.clone',
  'catalog::vendor.products.edit',
], \Modules\Variation\ViewComposers\Vendor\OptionComposer::class);


view()->composer([
  'catalog::vendor.products.html.tabs_variation_blank'
], \Modules\Variation\ViewComposers\Vendor\FindOptionValuesComposer::class);
