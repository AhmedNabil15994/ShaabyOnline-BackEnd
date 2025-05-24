<?php


/*
|================================================================================
|                             VENDOR ROUTES
|================================================================================
*/
Route::prefix('vendor-dashboard')->middleware(['vendor.auth', 'permission:seller_access'])->group(function () {

    /*foreach (File::allFiles(module_path('Tags', 'Routes/Vendor')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["gifts.php"] as $value) {
        require(module_path('Tags', 'Routes/Vendor/' . $value));
    }

});


/*
|================================================================================
|                             Back-END ROUTES
|================================================================================
*/
Route::prefix('dashboard')->middleware(['dashboard.auth', 'permission:dashboard_access'])->group(function () {

    /*foreach (File::allFiles(module_path('Tags', 'Routes/Dashboard')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["tags.php"] as $value) {
        require(module_path('Tags', 'Routes/Dashboard/' . $value));
    }

});

/*
|================================================================================
|                             FRONT-END ROUTES
|================================================================================
*/
Route::prefix('/')->group(function () {

    /*foreach (File::allFiles(module_path('Tags', 'Routes/FrontEnd')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["gifts.php"] as $value) {
        require(module_path('Tags', 'Routes/FrontEnd/' . $value));
    }

});
