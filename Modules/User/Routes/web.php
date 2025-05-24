<?php


/*
|================================================================================
|                             Back-END ROUTES
|================================================================================
*/
Route::prefix('dashboard')->middleware(['dashboard.auth', 'permission:dashboard_access'])->group(function () {

    /*foreach (File::allFiles(module_path('User', 'Routes/Dashboard')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["admins.php", "drivers.php", "sellers.php", "users.php", "addresses.php"] as $value) {
        require(module_path('User', 'Routes/Dashboard/' . $value));
    }

});

/*
|================================================================================
|                             FRONT-END ROUTES
|================================================================================
*/
Route::prefix('/')->group(function () {

    /*foreach (File::allFiles(module_path('User', 'Routes/FrontEnd')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["profile.php"] as $value) {
        require(module_path('User', 'Routes/FrontEnd/' . $value));
    }

});
