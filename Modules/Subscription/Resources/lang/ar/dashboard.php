<?php

return [
    'packages'      => [
        'create'    => [
            'form'  => [
                'description'       => 'الوصف',
                'general'           => 'بيانات عامة',
                'info'              => 'البيانات',
                'meta_description'  => 'Meta Description',
                'meta_keywords'     => 'Meta Keywords',
                'months'            => 'عدد اشهر الباقة',
                'other'             => 'بيانات الباقة',
                'price'             => 'السعر',
                'seo'               => 'SEO',
                'special_price'     => 'سعر خاص',
                'status'            => 'الحالة',
                'title'             => 'عنوان باقات',
            ],
            'title' => 'اضافة باقات المتاجر',
        ],
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'months'        => 'عدد اشهر الباقة',
            'options'       => 'الخيارات',
            'price'         => 'السعر',
            'special_price' => 'سعر خاص',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'index'     => [
            'title' => 'باقات المتاجر',
        ],
        'update'    => [
            'form'  => [
                'description'       => 'الوصف',
                'general'           => 'بيانات عامة',
                'meta_description'  => 'Meta Description',
                'meta_keywords'     => 'Meta Keywords',
                'months'            => 'عدد اشهر الباقة',
                'other'             => 'بيانات الباقة',
                'price'             => 'السعر',
                'seo'               => 'SEO',
                'special_price'     => 'سعر خاص',
                'status'            => 'الحالة',
                'title'             => 'عنوان باقات',
            ],
            'title' => 'تعديل باقات المتاجر',
        ],
        'validation'=> [
            'description'   => [
                'required'  => 'من فضلك ادخل وصف الباقات',
            ],
            'months'        => [
                'numeric'   => 'من فضلك ادخل عدد شهور الباقة ارقام فقط',
                'required'  => 'من فضلك ادخل عدد شهور الباقة',
            ],
            'price'         => [
                'numeric'   => 'من فضلك ادخل سعر الباقة ارقام فقط',
                'required'  => 'من فضلك ادخل سعر الباقة',
            ],
            'special_price' => [
                'numeric'   => 'من فضلك ادخل السعر الخاص ارقام فقط',
            ],
            'title'         => [
                'required'  => 'من فضلك ادخل عنوان الباقات',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
    'subscriptions' => [
        'create'    => [
            'form'  => [
                'general'   => 'بيانات عامة',
                'info'      => 'البيانات',
                'packages'  => 'اختر الباقة',
                'status'    => 'الحالة',
                'vendors'   => 'اختر المتجر',
            ],
            'title' => 'اضافة اشتراكات',
        ],
        'datatable' => [
            'created_at'        => 'تاريخ الآنشاء',
            'date_range'        => 'البحث بالتواريخ',
            'end_at'            => 'انتهاء الاشتراك',
            'options'           => 'الخيارات',
            'original_price'    => 'السعر الاصلي',
            'package'           => 'الباقة',
            'price'             => 'السعر النهائي',
            'start_at'          => 'يبدا بتاريخ',
            'status'            => 'الحالة',
            'vendor'            => 'المتجر',
        ],
        'index'     => [
            'title' => 'اشتراكات المتاجر',
        ],
        'update'    => [
            'form'  => [
                'end_at'            => 'ينتهي الاشتراك في',
                'general'           => 'بيانات عامة',
                'original_price'    => 'السعر الاصلي للباقة',
                'packages'          => 'اختر الباقة',
                'start_at'          => 'يبدا الاشتراك في',
                'status'            => 'الحالة',
                'total'             => 'السعر النهائي',
                'vendors'           => 'اختر المتجر',
            ],
            'title' => 'تعديل باقات المتاجر',
        ],
        'validation'=> [
            'end_at'        => [
                'required'  => 'من فضلك ادخل تاريخ انتهاء الاشتراك',
            ],
            'package_id'    => [
                'required'  => 'من فضلك اختر باقة الاشتراك',
            ],
            'total'         => [
                'required'  => 'من فضلك ادخل السعر النهائي',
            ],
            'vendor_id'     => [
                'required'  => 'من فضلك اختر متجر الاشتراك',
            ],
        ],
    ],
];
