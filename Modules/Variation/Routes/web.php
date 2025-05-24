<?php


/*
|================================================================================
|                             VENDOR ROUTES
|================================================================================
*/
Route::prefix('vendor')->middleware(['vendor.auth', 'permission:seller_access'])->group(function () {

    /*foreach (File::allFiles(module_path('Variation', 'Routes/Vendor')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["options.php"] as $value) {
        require(module_path('Variation', 'Routes/Vendor/' . $value));
    }

});


/*
|================================================================================
|                             Back-END ROUTES
|================================================================================
*/
Route::prefix('dashboard')->middleware(['dashboard.auth', 'permission:dashboard_access'])->group(function () {

    /*foreach (File::allFiles(module_path('Variation', 'Routes/Dashboard')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["options.php"] as $value) {
        require(module_path('Variation', 'Routes/Dashboard/' . $value));
    }

});

/*
|================================================================================
|                             FRONT-END ROUTES
|================================================================================
*/
Route::prefix('/')->group(function () {

    /*foreach (File::allFiles(module_path('Variation', 'Routes/FrontEnd')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["routes.php"] as $value) {
        require(module_path('Variation', 'Routes/FrontEnd/' . $value));
    }

});
