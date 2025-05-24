<?php

view()->composer(['user::dashboard.sellers.index'], \Modules\Authorization\ViewComposers\Dashboard\SellerRolesComposer::class);

view()->composer(['user::dashboard.admins.index'], \Modules\Authorization\ViewComposers\Dashboard\AdminRolesComposer::class);

view()->composer(['user::dashboard.drivers.index'], \Modules\Authorization\ViewComposers\Dashboard\DriverRolesComposer::class);
