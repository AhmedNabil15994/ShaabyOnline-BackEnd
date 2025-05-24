<?php


/*
|================================================================================
|                             Back-END ROUTES
|================================================================================
*/
Route::prefix('dashboard')->middleware(['dashboard.auth', 'permission:dashboard_access'])->group(function () {

    /*foreach (File::allFiles(module_path('Area', 'Routes/Dashboard')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["cities.php", "countries.php", "states.php", "area.php"] as $value) {
        require(module_path('Area', 'Routes/Dashboard/' . $value));
    }
});

/*
|================================================================================
|                             FRONT-END ROUTES
|================================================================================
*/
Route::prefix('/')->group(function () {

    foreach (["area.php"] as $value) {
        require(module_path('Area', 'Routes/FrontEnd/' . $value));
    }
});

/*
|================================================================================
|                            VENDOR ROUTES
|================================================================================
*/
Route::prefix('vendor-dashboard')->middleware(['vendor.auth', 'permission:seller_access'])->group(function () {
    foreach (["area.php"] as $value) {
        require(module_path('Area', 'Routes/Vendor/' . $value));
    }
});
