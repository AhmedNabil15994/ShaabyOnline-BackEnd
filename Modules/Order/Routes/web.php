<?php


/*
|================================================================================
|                             DRIVER ROUTES
|================================================================================
*/
Route::prefix('driver-dashboard')->middleware(['driver.auth', 'permission:driver_access'])->group(function () {

    /*foreach (File::allFiles(module_path('Order', 'Routes/Driver')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["orders.php"] as $value) {
        require(module_path('Order', 'Routes/Driver/' . $value));
    }

});


/*
|================================================================================
|                            VENDOR ROUTES
|================================================================================
*/
Route::prefix('vendor-dashboard')->middleware(['vendor.auth', 'permission:seller_access'])->group(function () {

    /*foreach (File::allFiles(module_path('Order', 'Routes/Vendor')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["orders.php", "order-statuses.php"] as $value) {
        require(module_path('Order', 'Routes/Vendor/' . $value));
    }

});


/*
|================================================================================
|                             Back-END ROUTES
|================================================================================
*/
Route::prefix('dashboard')->middleware(['dashboard.auth', 'permission:dashboard_access'])->group(function () {

    /*foreach (File::allFiles(module_path('Order', 'Routes/Dashboard')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["orders.php", "order-statuses.php"] as $value) {
        require(module_path('Order', 'Routes/Dashboard/' . $value));
    }

});

/*
|================================================================================
|                             FRONT-END ROUTES
|================================================================================
*/
Route::prefix('/')->group(function () {

    /*foreach (File::allFiles(module_path('Order', 'Routes/FrontEnd')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["orders.php"] as $value) {
        require(module_path('Order', 'Routes/FrontEnd/' . $value));
    }

});
