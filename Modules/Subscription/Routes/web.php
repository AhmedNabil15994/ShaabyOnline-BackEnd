<?php


/*
|================================================================================
|                             Back-END ROUTES
|================================================================================
*/
Route::prefix('dashboard')->middleware(['dashboard.auth', 'permission:dashboard_access'])->group(function () {

    /*foreach (File::allFiles(module_path('Subscription', 'Routes/Dashboard')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["packages.php", "subscriptions.php"] as $value) {
        require(module_path('Subscription', 'Routes/Dashboard/' . $value));
    }

});

/*
|================================================================================
|                             FRONT-END ROUTES
|================================================================================
*/
Route::prefix('/')->group(function () {

    /*foreach (File::allFiles(module_path('Subscription', 'Routes/FrontEnd')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["routes.php"] as $value) {
        require(module_path('Subscription', 'Routes/FrontEnd/' . $value));
    }

});
