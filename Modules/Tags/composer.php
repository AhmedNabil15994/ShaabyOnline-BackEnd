<?php

// Dashboard View Composer
view()->composer([
    'catalog::dashboard.products.*',
    'catalog::vendor.products.*',
], \Modules\Tags\ViewComposers\Dashboard\TagComposer::class);
