<?php


/*
|================================================================================
|                             VENDOR ROUTES
|================================================================================
*/
Route::prefix('vendor-dashboard')->middleware(['vendor.auth', 'permission:seller_access'])->group(function () {

    /*foreach (File::allFiles(module_path('Catalog', 'Routes/Vendor')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["products.php"] as $value) {
        require(module_path('Catalog', 'Routes/Vendor/' . $value));
    }
});


/*
|================================================================================
|                             Back-END ROUTES
|================================================================================
*/
Route::prefix('dashboard')->middleware(['dashboard.auth', 'permission:dashboard_access'])->group(function () {

    /*foreach (File::allFiles(module_path('Catalog', 'Routes/Dashboard')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["categories.php", "products.php", "search-keywords.php", "addon_categories.php", "product_addons.php", "addon_options.php", "home_categories.php"] as $value) {
        require(module_path('Catalog', 'Routes/Dashboard/' . $value));
    }
});

/*
|================================================================================
|                             FRONT-END ROUTES
|================================================================================
*/
Route::prefix('/')->group(function () {

    /*foreach (File::allFiles(module_path('Catalog', 'Routes/FrontEnd')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["categories.php", "address.php", "checkout.php", "filter.php", "search.php", "shopping-cart.php", "products.php"] as $value) {
        require(module_path('Catalog', 'Routes/FrontEnd/' . $value));
    }
});
