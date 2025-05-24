<?php

return [
    'notifications' => [
        'title' => 'اضافة اشعارات عامة للمستخدمين',
        'send_btn' => 'إرسال',
        'form' => [
            'body' => 'محتوى الرسالة',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'status' => 'الحالة',
            'title' => 'عنوان الرسالة',
            'tabs' => [
                'general' => 'بيانات عامة',
                'seo' => 'SEO',
            ],
            'name' => 'ارسال الإشعارات',
            'msg_title' => 'عنوان الرسالة',
            'msg_title_placeholder' => 'مثال : شاهد المنتجات الجديدة',
            'msg_body' => 'محتوى الرسالة',
            'products' => 'المنتجات',
            'categories' => 'أقسام المنتجات',
            'notification_type' => [
                'label' => 'نوع الإشعار',
                'general' => 'عام',
                'product' => 'منتجات',
                'category' => 'أقسام منتجات',
            ],
        ],
        'routes' => [
            'create' => 'اضافة اشعارات عامة للمستخدمين',
            'index' => 'إشعارات عامة',
            'update' => 'تعديل الإشعار',
        ],
        'datatable' => [
            'created_at' => 'تاريخ الآنشاء',
            'date_range' => 'البحث بالتواريخ',
            'options' => 'الخيارات',
            'status' => 'الحالة',
            'title' => 'العنوان',
            'added_by' => 'أضيف بواسطة',
            'body' => 'المحتوى',
            'type' => 'النوع',
        ],
        'validation' => [
            'body' => [
                'required' => 'من فضلك ادخل محتوى الرسالة',
            ],
            'title' => [
                'required' => 'من فضلك ادخل عنوان الرسالة',
                'unique' => 'هذا العنوان تم ادخالة من قبل',
            ],
            'notification_type' => [
                'required' => 'من فضلك اختر نوع الإشعار',
                'in' => 'نوع الإشعار يجب ان يكون ضمن القيم الآتيه',
            ],
            'product_id' => [
                'required_if' => 'من فضلك اختر المنتج',
            ],
            'category_id' => [
                'required_if' => 'من فضلك اختر القسم',
            ],
        ],
        'general' => [
            'message_sent_success' => 'تم إرسال الإشعار بنجاح',
            'no_tokens' => 'لم يتم العثور على معرف الاجهزة',
        ],
    ],
];
