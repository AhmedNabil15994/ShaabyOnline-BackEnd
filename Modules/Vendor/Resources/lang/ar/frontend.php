<?php

return [
    'vendors'   => [
        'all_categories'        => 'الكل',
        'ask'                   => 'إسأل الصيدلاني',
//        'ask'                   => 'اسالنا',
        'ask_q'                 => [
            'alerts'    => [
                'send_question' => 'تم ارسال السؤال بنجاح',
            ],
            'btn'       => 'ارسال الوصفة',
            'btn_send_question'       => 'إرسال السؤال',
            'email'     => 'البريد الالكتروني',
            'mail'      => [
                'header'    => 'سؤال جديد',
                'subject'   => 'سؤال جديد',
            ],
            'name'      => 'الاسم',
            'question'  => 'السؤال ؟',
            'title'     => 'اسالنا',
            'pharmacist_title'     => 'إسأل الصيدلاني',
        ],
        'based_on_area'         => 'يعتمد على منطقةالتوصيل',
        'btn'                   => [
            'filter'    => 'تصفية',
        ],
        'charge_started'        => 'يبدا التوصيل من',
        'delivery_charge'       => 'تكلفة التوصيل',
        'delivery_time'         => 'مدة التوصيل',
        'filter'                => [
            'a_to_z'            => 'الابجدية',
            'charge_started'    => 'يبدا التوصيل من',
            'delivery_charge'   => 'تكلفة التوصيل',
            'delivery_time'     => 'مدة التوصيل',
            'latest'            => 'الاحدث',
            'order_limit'       => 'الحد الادنى للطلب',
            'payment_accepted'  => 'طريقة الدفع',
            'payments'          => 'طرق الدفع',
            'rating'            => 'التقيم',
            'select_sorted_by'  => 'اختر',
            'sorted_by'         => 'الترتيب',
            'title'             => 'فلتر',
            'vendor_status'     => 'الحالة',
            'search_placeholder'=> 'عما تبحث؟',
            'search_here'       => 'ابحث  هنا',
            'no_search_result'  => 'لا يوجد نتائج متطابقة',
        ],
        'filters'               => 'تصفية المنتجات',
        'filters_by_brands'     => 'العلامات التجارية',
        'filters_by_categories' => 'الاقسام',
        'filters_by_range_price'=> 'الاسعار',
        'new_product'           => 'جديد',
        'order_limit'           => 'الحد الادنى للطلب',
        'payments'              => 'طرق الدفع',
        'prescription'          => 'وصفة طبية',
        'prescription_r'        => [
            'alerts'    => [
                'send_prescription' => 'تم ارسال الوصفة الطبيه بنجاح',
            ],
            'btn'       => 'ارسال الوصفه',
            'email'     => 'البريد الالكتروني',
            'image'     => 'الصورة',
            'mail'      => [
                'header'    => 'وصفة طبية جديدة',
                'subject'   => 'وصفة طبية جديدة',
            ],
            'name'      => 'الاسم',
            'rocheta'   => 'الوصفة الطبية',
            'title'     => 'وصفة طبية',
        ],
        'product_details'       => 'تفاصيل اكثر',
        'section'               => [
            'based_on_area'     => 'يعتمد على منطقةالتوصيل',
            'charge_started'    => 'يبدا التوصيل من',
            'delivery_charge'   => 'تكلفة التوصيل',
            'delivery_time'     => 'مدة التوصيل',
            'order_limit'       => 'الحد الادنى للطلب',
            'payments'          => 'طرق الدفع',
            'title'             => 'القسم',
        ],
        'total_products'        => 'منتج',
    ],
    'prescription_form'        => [
        'validation'    =>  [
            'name'  => [
                'required'  => 'من فضلك ادخل الاسم',
                'string'  => 'الاسم يجب ان يكون نصى',
                'max'  => 'الاسم يجب ألا يتجاوز 300 حرف',
            ],
            'email'  => [
                'required'  => 'من فضلك ادخل البريد الإلكترونى',
                'email'  => 'الايميل يجب ان يكون عنوان بريد إلكترونى',
            ],
            'image'  => [
                'image'  => 'الملف يجب ان يكون من نوع صورة',
                'max'  => 'يجب ألا يزيد حجم الصورة عن 2 ميجا بايت',
            ],
        ],
    ],
    'ask_question_form'        => [
        'validation'    =>  [
            'name'  => [
                'required'  => 'من فضلك ادخل الاسم',
                'string'  => 'الاسم يجب ان يكون نصى',
                'max'  => 'الاسم يجب ألا يتجاوز 300 حرف',
            ],
            'email'  => [
                'required'  => 'من فضلك ادخل البريد الإلكترونى',
                'email'  => 'الايميل يجب ان يكون عنوان بريد إلكترونى',
            ],
            'question'  => [
                'required'  => 'من فضلك ادخل السؤال',
                'max'  => 'السؤال يجب ألا يتجاوز 3000 حرف',
            ],
        ],
    ],
];
