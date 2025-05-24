<?php

return [
    'advertising' => [
        'datatable' => [
            'created_at' => 'تاريخ الآنشاء',
            'date_range' => 'البحث بالتواريخ',
            'end_at' => 'الانتهاء في',
            'image' => 'الصورة',
            'link' => 'الرابط',
            'options' => 'الخيارات',
            'start_at' => 'يبدا في',
            'status' => 'الحاله',
            'advertising_group' => 'المجموعة الإعلانية',
        ],
        'form' => [
            'type' => 'نوع الاعلان',
            'end_at' => 'الانتهاء في',
            'image' => 'الصورة',
            'link' => 'رابط الاعلان',
            'start_at' => 'يبدا في',
            'status' => 'الحاله',
            'sort' => 'الترتيب',
            'products' => 'المنتجات',
            'categories' => 'أقسام المنتجات',
            'groups' => 'المجموعات الإعلانية',
            'vendors' => 'المتاجر',

            'link_type' => [
                'label' => 'نوع الرابط',
                'external' => 'خارجى',
                'product' => 'منتجات',
                'category' => 'أقسام منتجات',
                'vendor' => 'متاجر',
            ],
            'tabs' => [
                'general' => 'بيانات عامة',
            ],
        ],
        'routes' => [
            'create' => 'اضافة الاعلانات',
            'create_advert' => 'اضافة إعلان',
            'index' => 'الاعلانات',
            'update' => 'تعديل الاعلان',
            'all_adverts' => 'عرض الاعلانات',
        ],
        'alert' => [
            'select_position' => 'اختر مكان الاعلان',
            'select_products' => 'اختر المنتج',
            'select_categories' => 'اختر القسم',
            'select_groups' => 'اختر المجموعة الإعلانية',
            'select_vendors' => 'اختر المتجر',
        ],
        'validation' => [
            'end_at' => [
                'required' => 'من فضلك اختر تاريخ الانتهاء',
            ],
            'image' => [
                'required' => 'من فضلك اختر صورة الاعلان',
            ],
            'link' => [
                'required_if' => 'من فضلك ادخل رابط الاعلان',
            ],
            'product_id' => [
                'required' => 'من فضلك اختر المنتج',
                'exists' => 'منتج الاعلان غير موجود حاليا',
            ],
            'category_id' => [
                'required' => 'من فضلك اختر القسم',
                'exists' => 'قسم منتج الاعلان غير موجود حاليا',
            ],
            'start_at' => [
                'required' => 'من فضلك اختر تاريخ البدء',
            ],
            'link_type' => [
                'required' => 'من فضلك اختر نوع رابط الاعلان',
                'in' => 'نوع رابط الاعلان يجب ان يكون ضمن القيم: external,product,category',
            ],
            'group_id' => [
                'required' => 'من فضلك اختر مجموعة الاعلان',
                'exists' => 'مجموعة الاعلان غير موجودة حاليا',
            ],
            'vendor_id' => [
                'required' => 'من فضلك اختر المتجر',
                'exists' => 'المتجر غير موجود حاليا',
            ],
        ],
    ],
    'advertising_groups' => [
        'datatable' => [
            'created_at' => 'تاريخ الآنشاء',
            'date_range' => 'البحث بالتواريخ',
            'options' => 'الخيارات',
            'status' => 'الحاله',
            'title' => 'العنوان',
            'position' => 'المكان',
        ],
        'form' => [
            'title' => 'العنوان',
            'status' => 'الحاله',
            'sort' => 'الترتيب',
            'home' => 'الرئيسية',
            'categories' => 'الأقسام',
            'tabs' => [
                'general' => 'بيانات عامة',
            ],
            'position' => [
                'label' => 'مكان الاعلان',
                'home' => 'الرئيسية',
                'categories' => 'الأقسام',
            ],
        ],
        'routes' => [
            'create' => 'اضافة مجموعة اعلانيه',
            'index' => 'المجموعات الاعلانيه',
            'update' => 'تعديل مجموعة اعلانيه',
        ],
        'alert' => [
            'select_position' => 'اختر مكان الاعلان',
            'no_ad_groups_now' => 'لا يوجد مجموعات إعلانية حاليا',
        ],
        'validation' => [
            'title' => [
                'required' => 'من فضلك ادخل العنوان',
                'unique' => 'هذا العنوان تم ادخالة من قبل',
            ],
            'position' => [
                'required' => 'من فضلك اختر مكان الاعلان',
                'in' => 'مكان الاعلان يجب ان يكون ضمن القيم: home,categories',
            ],
        ],
    ],
];
