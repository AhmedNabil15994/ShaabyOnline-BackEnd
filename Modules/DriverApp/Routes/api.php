<?php

Route::group(['prefix' => 'drivers', 'middleware' => 'IsDriverAppUser'], function () {

    foreach (["auth.php", "orders.php", "user.php"] as $value) {
        require_once(module_path('DriverApp', 'Routes/Api/' . $value));
    }

});
