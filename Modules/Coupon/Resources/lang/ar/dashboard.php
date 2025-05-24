<?php

return [
    'coupons' => [
        'datatable' => [
            'code' => 'الكود',
            'created_at' => 'تاريخ الآنشاء',
            'date_range' => 'البحث بالتواريخ',
            'expired_at' => 'تاريخ انتهاء الصلاحية',
            'image' => 'الصورة',
            'options' => 'الخيارات',
            'status' => 'الحاله',
            'title' => 'العنوان',
        ],
        'form' => [
            'categories' => 'الأقسام',
            'code' => 'كود الخصم',
            'description' => 'وصف مختصر',
            'discount_percentage' => 'نسبة الخصم',
            'discount_type' => 'نوع الخصم',
            'discount_value' => 'قيمة الخصم',
            'end_at' => 'ينتهي في تاريخ',
            'expired_at' => 'تاريخ انتهاء الصلاحية',
            'image' => 'الصورة',
            'max_discount_percentage_value' => 'قيمة الحد الأقصى للخصم',
            'max_users' => 'أقصى عدد للمستخدمين',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'packages' => 'الباقات',
            'percentage' => 'نسبة',
            'products' => 'المنتجات',
            'start_at' => 'تاريخ بداية الصلاحية',
            'status' => 'الحالة',
            'tabs' => [
                'custom' => 'تخصيص كود الخصم',
                'general' => 'بيانات عامة',
                'seo' => 'SEO',
                'use' => 'صلاحية واستخدام كود الخصم',
            ],
            'title' => 'عنوان',
            'user_max_uses' => 'أقصى عدد لاستخدام المستخدم',
            'users' => 'المستخدمون',
            'value' => 'قيمة',
            'vendors' => 'المتاجر',
            'all_products' => 'كل المنتجات',
            'select2_coupon_users_placeholder' => 'جميع المستخدمين',
            'coupon_users_hint' => 'سيتم تطبيق الكوبون على جميع المستخدمين فى حالة عدم تحديد مستخدمين',
        ],
        'routes' => [
            'clone' => 'نسخ كوبون خصم',
            'create' => 'اضافة كوبون خصم',
            'index' => 'كوبونات الخصم',
            'update' => 'تعديل كوبون خصم',
        ],
        'validation' => [
            'code' => [
                'required' => 'من فضلك ادخل كود الخصم',
                'unique' => 'هذا الكود تم ادخالة من قبل',
            ],
            'discount_type' => [
                'required' => 'من فضلك ادخل نوع الخصم',
            ],
            'discount_value' => [
                'required_if' => 'من فضلك ادخل قيمة مبلغ الخصم',
            ],
            'discount_percentage' => [
                'required_if' => 'من فضلك ادخل النسبة المئوية للخصم',
            ],
            'coupon_flag' => [
                'required' => 'من فضلك اختر تخصيص الخصم',
                'in' => 'تخصيص الخصم ضمن:vendors,categories,products',
            ],
            'vendor_ids' => [
                'required_if' => 'من فضلك اختر المتاجر',
            ],
            'category_ids' => [
                'required_if' => 'من فضلك اختر اقسام المنتجات',
            ],
            'product_ids' => [
                'required_if' => 'من فضلك اختر المنتجات',
            ],
            'start_at' => [
                'required' => 'من فضلك ادخل تاريخ بداية الصلاحية',
                'date_format' => 'ادخل تاريخ بداية الصلاحية بصيغة Y-m-d',
                'after_or_equal' => 'تاريخ بداية الصلاحية يجب ان يكون اكبر من او يساوى تاريخ اليوم',
            ],
            'expired_at' => [
                'required' => 'من فضلك ادخل تاريخ انتهاء الصلاحية',
                'date_format' => 'ادخل تاريخ انتهاء الصلاحية بصيغة Y-m-d',
                'after' => 'تاريخ انتهاء الصلاحية يجب ان يكون اكبر من او يساوى تاريخ اليوم',
            ],
        ],
    ],
];
