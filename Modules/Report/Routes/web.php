<?php


/*
|================================================================================
|                             Back-END ROUTES
|================================================================================
*/
Route::prefix('dashboard')->middleware(['dashboard.auth', 'permission:dashboard_access'])->group(function () {

    /*foreach (File::allFiles(module_path('Report', 'Routes/Dashboard')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["routes.php", "reports.php"] as $value) {
        require(module_path('Report', 'Routes/Dashboard/' . $value));
    }

});
