<?php

return [
    'shipping_company' => [
        'validations' => [
            'availabilities' => [
                'day_code' => [
                    'required' => 'ادخل كود يوم التوصيل',
                ],
                'day' => [
                    'required' => 'ادخل يوم التوصيل',
                ],
                'time_from' => [
                    'required' => 'ادخل الوقت من ليوم التوصيل',
                ],
                'time_to' => [
                    'required' => 'ادخل الوقت الى ليوم التوصيل',
                ],
            ],
        ],
    ],
    'driver' => [
        'order_not_found' => 'هذا الطلب غير موجود',
        'order_assigned_befor' => 'تم إسناد الطلب للسائق',
        'oops_error' => 'حدث خطأ ما, بالرجاء المحاولة لاحقا!',
        'you_have_pending_order' => 'عفوا لديك طلب لم يتم تسليمه',
    ],
];
