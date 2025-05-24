<?php


/*
|================================================================================
|                             Back-END ROUTES
|================================================================================
*/
Route::prefix('dashboard')->middleware(['dashboard.auth', 'permission:dashboard_access'])->group(function () {

    /*foreach (File::allFiles(module_path('Setting', 'Routes/Dashboard')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["settings.php"] as $value) {
        require(module_path('Setting', 'Routes/Dashboard/' . $value));
    }

});
