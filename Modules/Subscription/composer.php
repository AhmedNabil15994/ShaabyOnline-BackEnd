<?php

// DASHBOARD VIEW COMPOSER
view()->composer(['subscription::dashboard.subscriptions.*'], \Modules\Subscription\ViewComposers\Dashboard\PackageComposer::class);
