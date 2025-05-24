<?php

view()->composer(['apps::dashboard.index'], \Modules\Report\ViewComposers\Dashboard\UserComposer::class);

view()->composer(['apps::dashboard.index'], \Modules\Report\ViewComposers\Dashboard\VendorComposer::class);

view()->composer(['apps::dashboard.index'], \Modules\Report\ViewComposers\Dashboard\OrderComposer::class);

view()->composer(['apps::vendor.index'], \Modules\Report\ViewComposers\Vendor\OrderComposer::class);
