<?php

return [
    'order_statuses'    => [
        'datatable' => [
            'color_label'   => 'لون الحالة',
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'failed_status' => 'حالة طلب غير ناجحة',
            'label_color'   => 'لون الحالة',
            'options'       => 'الخيارات',
            'success_status'=> 'حالة طلب ناجحة',
            'title'         => 'العنوان',
        ],
        'form'      => [
            'color_label'   => 'لون الحالة',
            'failed_status' => 'حالة طلب غير ناجحة',
            'label_color'   => 'لون الحالة',
            'success_status'=> 'حالة طلب ناجحة',
            'tabs'          => [
                'general'   => 'بيانات عامة',
            ],
            'title'         => 'عنوان الحالة',
        ],
        'routes'    => [
            'create'    => 'اضافة حالات الطلبات',
            'index'     => 'حالات الطلبات',
            'update'    => 'تعديل حالة الطلبات',
        ],
        'validation'=> [
            'color_label'   => [
                'required'  => 'من فضلك اختر لون / نوع الحالة',
            ],
            'label_color'   => [
                'required'  => 'من فضلك اختر لون / نوع الحالة',
            ],
            'title'         => [
                'required'  => 'من فضلك ادخل عنوان الحالة',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
    'orders'            => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'options'       => 'الخيارات',
            'shipping'      => 'التوصيل',
            'subtotal'      => 'المجموع',
            'total'         => 'المجموع الكلي',
        ],
        'index'     => [
            'title' => 'الطلبات',
        ],
        'show'      => [
            'address'           => [
                'block'     => 'القطعه',
                'building'  => 'البنايه',
                'city'      => 'المحافظة',
                'data'      => 'بيانات عنوان التوصيل',
                'state'     => 'المنطقة',
                'street'    => 'الشارع',
            ],
            'edit'              => 'تعديل حالة الطلب',
            'invoice'           => 'الفاتورة',
            'invoice_customer'  => 'فاتورة العميل',
            'items'             => [
                'data'      => 'المنتجات',
                'options'   => 'خيارات',
                'price'     => 'السعر',
                'qty'       => 'الكمية',
                'title'     => 'اسم المنتج',
                'total'     => 'المجموع',
            ],
            'order'             => [
                'data'      => 'بيانات الطلب',
                'off'       => 'الخصم',
                'shipping'  => 'التوصيل',
                'subtotal'  => 'المجموع',
                'total'     => 'المجموع الكلي',
            ],
            'other'             => [
                'data'                      => 'بيانات اضافية',
                'total_comission'           => 'نسبة الربح من المتجر',
                'total_profit'              => 'ربح الفرق ( الشراء و البيع )',
                'total_profit_comission'    => 'مجموع الارباح',
                'vendor'                    => 'المتجر',
            ],
            'title'             => 'عرض الطلب',
            'user'              => [
                'data'      => 'بيانات العميل',
                'email'     => 'البريد الالكتروني',
                'mobile'    => 'رقم الهاتف',
                'username'  => 'اسم العميل',
            ],
        ],
    ],
];
