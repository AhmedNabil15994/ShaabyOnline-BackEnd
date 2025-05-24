<?php

return [
    'options' => [
        'form' => [
            'status' => 'الحالة',
            'title' => 'عنوان خصائص المنتجات',
            'option_as_filter' => 'الإختيار كـ فلتر',
            'tabs' => [
                'general' => 'بيانات عامة',
                'option_values' => 'القيم',
            ],
            'notes' => 'ملاحظات',
            'is_color' => 'لون',
            'value' => 'اللون',
        ],
        'routes' => [
            'create' => 'اضافة خصائص المنتجات',
            'index' => 'خصائص المنتجات',
            'update' => 'تعديل خصائص المنتجات',
        ],
        'datatable' => [
            'created_at' => 'تاريخ الآنشاء',
            'date_range' => 'البحث بالتواريخ',
            'options' => 'الخيارات',
            'status' => 'الحالة',
            'title' => 'العنوان',
            'notes' => 'ملاحظات',
        ],
        'validation' => [
            'option_have_product_options' => 'عفواً, هذا الاختيار موجود ضمن منتجات اخرى',
            'title' => [
                'required' => 'من فضلك ادخل عنوان خصائص المنتجات',
                'unique' => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
    'option_values' => [
        'validation' => [
            'title' => [
                'required' => 'من فضلك ادخل قيم عنوان خصائص المنتجات',
            ],
            'option_value' => [
                'required' => 'من فضلك ادخل قيم خصائص المنتجات',
            ],
        ],
    ],
];
