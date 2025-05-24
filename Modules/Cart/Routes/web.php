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

    foreach (["routes.php"] as $value) {
        require(module_path('Cart', 'Routes/Vendor/' . $value));
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

    foreach (["routes.php"] as $value) {
        require(module_path('Cart', 'Routes/Dashboard/' . $value));
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

    foreach (["routes.php"] as $value) {
        require(module_path('Cart', 'Routes/FrontEnd/' . $value));
    }

});
