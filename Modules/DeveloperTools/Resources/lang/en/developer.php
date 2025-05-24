<?php

return [
    'login' => [
        'form'          => [
            'btn'       => [
                'login' => 'Login Now',
            ],
            'email'     => 'ِEmail address',
            'password'  => 'Password',
        ],
        'routes'        => [
            'index' => 'Login',
        ],
        'validations'   => [
            'email'     => [
                'email'     => 'Please add correct email format',
                'required'  => 'Please add your email address',
            ],
            'failed'    => 'These credentials do not match our records.',
            'password'  => [
                'min'       => 'Password must be more than 6 characters',
                'required'  => 'The password field is required',
            ],
        ],
    ],
    'home' => [
        'statistics' => [
            'comleted_orders' => 'Completed Orders',
            'count_subscribed_vendors' => 'Active Vendors',
            'count_users' => 'Clients',
            'count_vendors' => 'All Vendors',
            'orders_monthly' => 'Orders Monthly Chart',
            "yearProfit" => "Year Profit",
            "monthProfit" => "Month Profit",
            "todayProfit" => "Today Profit",
            'orders_status' => 'Orders Statuses',
            'title' => 'Statistics',
            'total_completed_orders' => 'Total Completed Orders',
            'users_created_at' => 'Clients Created At',
            'total_profit_commission' => 'Total Profit Commission',
        ],
        'title' => 'Theme Colors',
        'welcome_message' => 'Welcome',
    ],
    'navbar' => [
        'logout' => 'Logout',
        'profile' => 'Profile',
    ],

    'aside' => [
        'colors' => 'Colors',
    ],

    'themes' => [
        'colors' => [
            'routes' => [
                'index' => 'Colors'
            ]
        ]
    ],
];
