<?php


/*
|================================================================================
|                             Back-END ROUTES
|================================================================================
*/
Route::prefix('dashboard')->middleware(['dashboard.auth', 'permission:dashboard_access'])->group(function () {

    /*foreach (File::allFiles(module_path('DeviceToken', 'Routes/Dashboard')) as $file) {
        require($file->getPathname());
    }*/

    foreach (["notifications.php"] as $value) {
        require(module_path('DeviceToken', 'Routes/Dashboard/' . $value));
    }

});
