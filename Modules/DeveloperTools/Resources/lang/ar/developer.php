<?php

return [
    'login' => [
        'form'          => [
            'btn'       => [
                'login' => 'تسجيل الدخول',
            ],
            'email'     => 'البريد الالكتروني',
            'password'  => 'كلمة المرور',
        ],
        'routes'        => [
            'index' => 'تسجيل الدخول',
        ],
        'validations'   => [
            'email'     => [
                'email'     => 'من فضلك ادخل البريد بشكل صحيح',
                'required'  => 'من فضلك ادخل البريد الالكتروني',
            ],
            'failed'    => 'هذه البيانات غير متطابقة لدينا من فضلك تآكد من بيانات تسجيل الدخول',
            'password'  => [
                'min'       => 'كلمة المرور يجب ان تكون اكثر من ٦ مدخلات',
                'required'  => 'يجب ان تدخل كلمة المرور',
            ],
        ],
    ],
    'home' => [
        'statistics' => [
            'comleted_orders' => 'الطلبات المكتملة',
            'count_subscribed_vendors' => 'المتاجر المفعلة',
            'count_users' => 'العملاء',
            'count_vendors' => 'المتاجر',
            'orders_monthly' => 'الطلبات الشهرية',
            "yearProfit" => "المحصله السنويه",
            "monthProfit" => "المحصله الشهريه",
            "todayProfit" => "المحصله اليومى",
            'orders_status' => 'حالات الطلبات',
            'title' => 'احصائيات',
            'total_completed_orders' => 'مجموع الطلبات المكتملة',
            'users_created_at' => 'تاريخ انشاء العملاء بالاشهر',
            'total_profit_commission' => 'عمولة الربح الإجمالية',
        ],
        'title' => 'ألوان الموقع',
        'welcome_message' => 'اهلا بك',
    ],
    'navbar' => [
        'logout' => 'تسجيل خروج',
        'profile' => 'الملف الشخصي',
    ],

    'aside' => [
        'colors' => 'الألوان',
    ],

    'themes' => [
        'colors' => [
            'routes' => [
                'index' => 'الألوان'
            ]
        ]
    ],
];
