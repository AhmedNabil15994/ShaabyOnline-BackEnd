<?php


/*
|================================================================================
|                             DRIVER ROUTES
|================================================================================
*/
Route::prefix('driver-dashboard')->group(function () {

    /*foreach (File::allFiles(module_path('Authentication', 'Routes/Driver')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["login.php", "logout.php"] as $value) {
        require(module_path('Authentication', 'Routes/Driver/' . $value));
    }

});

/*
|================================================================================
|                             VENDOR ROUTES
|================================================================================
*/
Route::prefix('vendor-dashboard')->group(function () {

    /*foreach (File::allFiles(module_path('Authentication', 'Routes/Vendor')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["login.php", "logout.php"] as $value) {
        require(module_path('Authentication', 'Routes/Vendor/' . $value));
    }

});


/*
|================================================================================
|                             Back-END ROUTES
|================================================================================
*/
Route::prefix('dashboard')->group(function () {

    /*foreach (File::allFiles(module_path('Authentication', 'Routes/Dashboard')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["login.php", "logout.php", "password.php"] as $value) {
        require(module_path('Authentication', 'Routes/Dashboard/' . $value));
    }

});

/*
|================================================================================
|                             FRONT-END ROUTES
|================================================================================
*/
Route::prefix('/')->group(function () {

    /*foreach (File::allFiles(module_path('Authentication', 'Routes/FrontEnd')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["login.php", "logout.php", "password.php", "register.php", "reset.php", "verification-code.php"] as $value) {
        require(module_path('Authentication', 'Routes/FrontEnd/' . $value));
    }

});
