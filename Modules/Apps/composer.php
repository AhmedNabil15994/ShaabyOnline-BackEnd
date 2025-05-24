<?php

view()->composer(
    [
        'apps::dashboard.layouts._aside',
    ],
    \Modules\Apps\ViewComposers\Dashboard\StatisticsComposer::class
);
