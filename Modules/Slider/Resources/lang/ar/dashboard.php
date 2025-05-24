<?php

return [
    'slider' => [
        'datatable' => [
            'created_at' => 'تاريخ الآنشاء',
            'date_range' => 'البحث بالتواريخ',
            'end_at' => 'الانتهاء في',
            'image' => 'الصورة',
            'link' => 'الرابط',
            'options' => 'الخيارات',
            'start_at' => 'يبدأ في',
            'status' => 'الحاله',
            'type' => 'النوع',
        ],
        'form' => [
            'end_at' => 'الانتهاء في',
            'image' => 'الصورة',
            'link' => 'رابط السلايدر',
            'start_at' => 'يبدأ في',
            'status' => 'الحاله',
            'title' => 'العنوان',
            'short_description' => 'الوصف المختصر',
            'tabs' => [
                'general' => 'بيانات عامة',
            ],
            'products' => 'المنتجات',
            'categories' => 'أقسام المنتجات',
            'vendors' => 'متاجر',
            'slider_type' => [
                'label' => 'نوع السلايدر',
                'external' => 'خارجى',
                'product' => 'منتجات',
                'category' => 'أقسام منتجات',
                'vendor' => 'متاجر',
            ],
        ],
        'alert' => [
            'select_products' => 'اختر المنتج',
            'select_categories' => 'اختر القسم',
            'select_vendors' => 'اختر المتجر',
        ],
        'routes' => [
            'create' => 'اضافة صور السلايدر',
            'index' => 'صور السلايدر',
            'update' => 'تعديل السلايدر',
        ],
        'validation' => [
            'end_at' => [
                'required' => 'من فضلك اختر تاريخ الانتهاء',
            ],
            'image' => [
                'required' => 'من فضلك اختر صورة السلايدر',
            ],
            'link' => [
                'required' => 'من فضلك ادخل رابط السلايدر',
                'required_if' => 'من فضلك ادخل رابط السلايدر',
            ],
            'start_at' => [
                'required' => 'من فضلك اختر تاريخ البدء',
            ],
            'title' => [
                'required' => 'من فضلك ادخل عنوان السلايدر',
            ],
            'slider_type' => [
                'required' => 'من فضلك اختر نوع السلايدر',
                'in' => 'نوع السلايدر يجب ان يكون ضمن القيم الآتيه',
            ],
            'product_id' => [
                'required_if' => 'من فضلك اختر المنتج',
            ],
            'category_id' => [
                'required_if' => 'من فضلك اختر القسم',
            ],
            'vendor_id' => [
                'required_if' => 'من فضلك اختر المتجر',
            ],
        ],
    ],
];
