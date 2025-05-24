<?php

// Dashboard View Composer
view()->composer([
    'vendor::dashboard.vendors.*',
    'user::dashboard.drivers.*',
    'setting::dashboard.*',
], \Modules\Company\ViewComposers\Dashboard\CompanyComposer::class);
