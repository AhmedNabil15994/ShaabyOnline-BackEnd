<?php

return [
    'brands' => [
        'datatable' => [
            'created_at' => 'تاريخ الآنشاء',
            'date_range' => 'البحث بالتواريخ',
            'image' => 'الصورة',
            'options' => 'الخيارات',
            'status' => 'الحالة',
            'title' => 'العنوان',
        ],
        'form' => [
            'image' => 'الصورة',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'status' => 'الحالة',
            'tabs' => [
                'general' => 'بيانات عامة',
                'seo' => 'SEO',
            ],
            'title' => 'عنوان',
        ],
        'routes' => [
            'create' => 'اضافة العلامات التجارية',
            'index' => 'العلامات التجارية',
            'update' => 'تعديل العلامة التجارية',
        ],
        'validation' => [
            'image' => [
                'required' => 'من فضلك اختر الصورة',
            ],
            'title' => [
                'required' => 'من فضلك ادخل العنوان',
                'unique' => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
    'categories' => [
        'datatable' => [
            'created_at' => 'تاريخ الآنشاء',
            'date_range' => 'البحث بالتواريخ',
            'image' => 'الصورة',
            'options' => 'الخيارات',
            'status' => 'الحالة',
            'title' => 'العنوان',
            'type' => 'النوع',
        ],
        'form' => [
            'image' => 'الصورة',
            'cover' => 'صورة الغلاف',
            'main_category' => 'قسم رئيسي',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'status' => 'الحالة',
            'show_in_home' => 'يظهر فى الرئيسية',
            'tabs' => [
                'category_level' => 'مستوى الاقسام',
                'general' => 'بيانات عامة',
                'seo' => 'SEO',
            ],
            'title' => 'عنوان',
            'color' => 'اللون',
            'sort' => 'الترتيب',
            'color_hint' => 'اللون بطريقة Hex Color - على سبيل المثال: FFFFFF',
        ],
        'routes' => [
            'create' => 'اضافة الاقسام',
            'index' => 'الاقسام',
            'update' => 'تعديل القسم',
        ],
        'validation' => [
            'category_id' => [
                'required' => 'من فضلك اختر مستوى القسم',
            ],
            'image' => [
                'required' => 'من فضلك اختر الصورة',
            ],
            'title' => [
                'required' => 'من فضلك ادخل العنوان',
                'unique' => 'هذا العنوان تم ادخالة من قبل',
            ],
            'color' => [
                'required_if' => 'من فضلك ادخل لون للقسم الرئيسى',
            ],
        ],
    ],
    'products' => [
        'datatable' => [
            'created_at' => 'تاريخ الآنشاء',
            'date_range' => 'البحث بالتواريخ',
            'image' => 'الصورة',
            'options' => 'الخيارات',
            'status' => 'الحالة',
            'title' => 'العنوان',
            'vendor' => 'المتجر',
            'price' => 'السعر',
            'qty' => 'الكمية',
            'categories' => 'الأقسام',
            'product_flag' => 'نوع المنتج',
        ],
        'form' => [
            "import_photos" => "استيراد الصور",
            'arrival_end_at' => 'تاريخ الانتهاء',
            'arrival_start_at' => 'تاريخ البدء',
            'arrival_status' => 'حالة الوصول حديثا',
            'brands' => 'العلامة التجارية للمنتج',
            'cost_price' => 'سعر الشراء',
            'description' => 'الوصف',
            'short_description' => 'وصف قصير',
            "new_add" => "الاضافات الجديده",
            "empty_options" => "لايوحد اضافات",
            'end_at' => 'ينتهي في',
            'image' => 'الصورة',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'offer' => 'تخفيض المنتج',
            'offer_price' => 'سعر الخصم',
            "width" => "العرض",
            "height" => "الارتفاع",
            "weight" => "الوزن",
            "length" => "الطول",
            "shipment" => "ابعاد المنتج",
            "tags" => "وسوم المنتج - Tags",
            "add_variations" => "عرض إختلافات المنتج",
            'product_flag' => 'نوع المنتج',
            'single' => 'فردى',
            'variant' => 'متعدد',
            'is_new' => 'منتج جديد',
            
            'offer_status' => 'حالة التخفيض',
            'options' => 'اختيارات',
            'percentage' => 'نسبة مئوية',
            'price' => 'السعر',
            'qty' => 'الكمية',
            'sku' => 'كود المنتج',
            'start_at' => 'يبدء في',
            'main_products' => 'المنتج',
            'status' => 'الحالة',
            'featured' => 'منتج مميز',
            'browse_image' => 'اختر صورة',
            'btn_add_more' => 'اضافة المزيد',
            'vendor' => 'المتجر',
            'created_at' => 'تاريخ الإنشاء',
            'pending_for_approval' => 'الموافقة على المنتج',
            'sort' => 'الترتيب',
            "home_categories" => "اقسام الصفحة الرئيسية",

            'offer_type' => [
                'label' => 'النوع',
                'amount' => 'مبلغ',
                'percentage' => 'نسبة مئوية',
            ],

            'import_selects' => [
                'title_ar' => 'العنوان بالعربية',
                'title_en' => 'العنوان بالإنجليزية',
                'price' => 'السعر',
                'description_ar' => ' الوصف بالعربية',
                'description_en' => ' الوصف بالإنجليزية',
                'qty' => 'الكمية',
                'sku' => 'كود المنتج',
                'status' => 'الحالة',
                'international_code' => ' كود المنتج (international)',
                'category' => 'الأقسام',
                'offer_price' => 'السعر بعد العرض',
                'offer_start_at' => 'بداية تاريخ العرض',
                'offer_end_at' => 'نهاية تاريخ العرض',
            ],

            'tabs' => [
                'export' => 'نسخ المنتجات',
                'categories' => 'اقسام المنتج',
                'gallery' => 'معرض الصور',
                'general' => 'بيانات عامة',
                'new_arrival' => 'وصل حديثا',
                'seo' => 'SEO',
                'stock' => 'المخزون و السعر',
                'variations' => 'اختلافات المنتج',
                'add_ons' => 'إضافات المنتج',
                'edit_add_ons' => 'تعديل إضافات المنتج',
                "shipment" => "ابعاد المنتج",
                "input_lang" => "بيانات :lang",
                "images" => "صور إضافية / أكثر",
                "tags" => "وسوم المنتج - Tags",
                'search_keywords' => 'كلمات البحث',
            ],
            'title' => 'عنوان',
            'vendors' => 'متجر المنتج',
            'add_ons' => [
                'title' => 'الإضافة',
                'product' => 'المنتج',
                'name' => 'الاسم',
                'type' => 'النوع',
                'single' => 'اختيار واحد',
                'multiple' => 'اختيار متعدد',
                'option' => 'الإختيار',
                'price' => 'السعر',
                'qty' => 'الكمية',
                'image' => 'الصورة',
                'default' => 'إفتراضي',
                'add_more' => 'إضافة المزيد',
                'save_options' => 'حفظ',
                'add_ons_name' => 'اسم الإضافة',
                'show' => 'عرض',
                'delete' => 'حذف',
                'reset_form' => 'إضافة جديد',
                'customer_can_select_exactly' => 'يمكن للعميل الاختيار بدقة',
                'options_count' => 'عدد الإختيارات',
                'min_options_count' => 'الحد الأدنى',
                'max_options_count' => 'الحد الأقصى',
                'created_at' => 'تاريخ الإنشاء',
                'operations' => 'العمليات',
                'clear_defaults' => 'إزالة الإفتراضى',
                'confirm_msg' => 'هل انت متأكد ؟',
                'at_least_one_field' => 'مطلوب حقل واحد على الأقل',
                'options_count_greater_than_rows' => 'عدد إختيارات العميل يجب ان يكون اقل من إجمالى الإختيارات',
                'loading' => 'جارى التحميل ...',
                'is_required' => 'اختيار إجبارى',
            ],

            'unlimited' => 'كمية غير محدودة',
            'limited' => 'تحديد الكمية',
        ],
        'routes' => [
            'clone' => 'نسخ و اضافة منتج جديد',
            'create' => 'اضافة المنتجات',
            'index' => 'المنتجات',
            'update' => 'تعديل المنتج',
            'add_ons' => 'إضافات المنتج',
            'review_products' => 'منتجات تحت المراجعة',
            'show' => 'تفاصيل المنتج',
        ],
        'validation' => [
            'select_option_values' => 'من فضلك اختر قيم لإختيارات المنتج',
            'arrival_end_at' => [
                'date' => 'من فضلك ادخل تاريخ الانتهاء - وصل حديثا كتاريخ فقط',
                'required' => 'من فضلك ادخل تاريخ الانتهاء - وصل حديثا',
            ],
            'arrival_start_at' => [
                'date' => 'من فضلك ادخل تاريخ البدء - وصل حديثا كتاريخ فقط',
                'required' => 'من فضلك ادخل تاريخ البدء - وصل حديثا',
            ],
            'brand_id' => [
                'required' => 'من فضلك اختر العلامة التجارية',
            ],
            "width" => [
                'required' => 'من فضلك ادخل العرض',
                'numeric' => 'من فضلك ادخل العرض ارقام فقط',
            ],
            "length" => [
                'required' => 'من فضلك ادخل الطول',
                'numeric' => 'من فضلك ادخل الطول ارقام فقط',
            ],
            "weight" => [
                'required' => 'من فضلك ادخل الوزن',
                'numeric' => 'من فضلك ادخل الوزن ارقام فقط',
            ],
            "height" => [
                'required' => 'من فضلك ادخل الارتفاع',
                'numeric' => 'من فضلك ادخل الارتفاع ارقام فقط',
            ],
            'category_id' => [
                'required' => 'من فضلك اختر على الاقل قسم واحد',
            ],
            'cost_price' => [
                'numeric' => 'من فضلك ادخل سعر الشراء ارقام فقط',
                'required' => 'من فضلك ادخل سعر الشراء',
            ],
            'end_at' => [
                'date' => 'من فضلك ادخل تاريخ الانتهاء - الخصم كتاريخ فقط',
                'required' => 'من فضلك ادخل تاريخ الانتهاء - الخصم',
            ],
            'offer_type' => [
                'numeric' => 'يجب أن يكون نوع العرض ضمن هذه الأنواع',
                'required' => 'من فضلك اختر نوع العرض',
            ],
            'offer_price' => [
                'numeric' => 'من فضلك ادخل سعر الخصم للمنتج ارقام فقط',
                'required' => 'من فضلك ادخل سعر الخصم للمنتج',
            ],
            'offer_percentage' => [
                'numeric' => 'من فضلك ادخل قيمة النسبة المئوية للخصم ارقام فقط',
                'required' => 'من فضلك ادخل قيمة النسبة المئوية للخصم',
            ],
            'price' => [
                'numeric' => 'من فضلك ادخل السعر ارقام فقط',
                'required' => 'من فضلك ادخل السعر',
            ],
            'qty' => [
                'numeric' => 'من فضلك ادخل الكمية ارقام فقط',
                'min' => 'من فضلك ادخل الكمية ارقام اكبر من',
                'required' => 'من فضلك ادخل الكمية',
            ],
            'sku' => [
                'required' => 'من فضلك ادخل كود المنتج',
            ],
            'start_at' => [
                'date' => 'من فضلك ادخل تاريخ البدء - الخصم كتاريخ فقط',
                'required' => 'من فضلك ادخل تاريخ البدء - الخصم',
            ],
            'title' => [
                'required' => 'من فضلك ادخل العنوان',
                'unique' => 'هذا العنوان تم ادخالة من قبل',
            ],
            'variation_price' => [
                'required' => 'من فضلك ادخل سعر المنتج الاختياري',
            ],
            'variation_qty' => [
                'required' => 'من فضلك ادخل كمية المنتج الاختياري',
            ],
            'variation_sku' => [
                'required' => 'من فضلك ادخل كود المنتج الاختياري',
            ],
            'variation_status' => [
                'required' => 'من فضلك اختر حالة المنتج الاختياري',
            ],
            'vendor_id' => [
                'required' => 'من فضلك اختر المتجر',
            ],
            'image' => [
                'required' => 'من فضلك ادخل الصورة',
                'image' => 'من فضلك ادخل الصورة من نوع صورة',
                'mimes' => 'الصورة يجب ان تكون ضمن',
                'max' => 'حجم الصورة يجب الا يزيد عن',
            ],
            'add_ons' => [
                'option_name' => [
                    'required' => 'من فضلك ادخل اسم إضافة المنتج',
                ],
                'add_ons_type' => [
                    'required' => 'من فضلك اختر نوع إضافة المنتج',
                    'in' => 'نوع إضافة المنتج يجب ان تكون بين',
                ],
                'price' => [
                    'required' => 'من فضلك ادخل سعر اختيار إضافة المنتج',
                    'array' => 'سعر اختيار إضافة المنتج يجب ان يكون مصفوفة',
                ],
                'rowId' => [
                    'required' => 'من فضلك ادخل ارقام "IDs" إضافة المنتج',
                    'array' => 'ارقام "IDs" إضافة المنتج يجب ان يكون مصفوفة',
                ],
                'option' => [
                    'required' => 'من فضلك ادخل عناوين اختيار إضافة المنتج',
                    'array' => 'اختيار إضافة المنتج يجب ان يكون مصفوفة',
                    'min' => 'اختيار إضافة المنتج يجب ان يحتوى على عنصر واحد',
                ],
            ],
            'images' => [
                'mimes' => 'الملف غير مدعوم كصورة من صور المنتج',
                'max' => 'حجم صورة (صور) المنتج اكبرمن 1 ميجا بايت',
            ],
            'tags' => [
                'array' => 'وسوم المنتج يجب ان تكون من نوع مصفوفة',
            ],
            'search_keywords' => [
                'array' => 'كلمات بحث المنتج يجب ان تكون من نوع مصفوفة',
            ],
        ],
    ],
    'search_keywords' => [
        'datatable' => [
            'created_at' => 'تاريخ الآنشاء',
            'date_range' => 'البحث بالتواريخ',
            'image' => 'الصورة',
            'options' => 'الخيارات',
            'status' => 'الحالة',
            'title' => 'العنوان',
        ],
        'form' => [
            'description' => 'الوصف',
            'short_description' => 'وصف قصير',
            'status' => 'الحالة',
            'title' => 'العنوان',
            'tabs' => [
                'export' => 'نسخ كلمات البحث',
                'general' => 'بيانات عامة',
                'seo' => 'SEO',
                "input_lang" => "بيانات :lang",
            ],
        ],
        'routes' => [
            'clone' => 'نسخ و اضافة كلمة بحث جديدة',
            'create' => 'اضافة كلمات البحث',
            'index' => 'كلمات البحث',
            'update' => 'تعديل كلمة البحث',
            'show' => 'تفاصيل كلمة البحث',
        ],
        'validation' => [
            'title' => [
                'required' => 'من فضلك ادخل العنوان',
                'unique' => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
    'addon_categories' => [
        'datatable' => [
            'created_at' => 'تاريخ الآنشاء',
            'date_range' => 'البحث بالتواريخ',
            'image' => 'الصورة',
            'options' => 'الخيارات',
            'status' => 'الحالة',
            'title' => 'العنوان',
            'type' => 'النوع',
            'sort' => 'الترتيب',
        ],
        'form' => [
            'image' => 'الصورة',
            'status' => 'الحالة',
            'tabs' => [
                'general' => 'بيانات عامة',
            ],
            'title' => 'عنوان',
            'color' => 'اللون',
            'sort' => 'الترتيب',
            'color_hint' => 'اللون بطريقة Hex Color - على سبيل المثال: FFFFFF',
        ],
        'routes' => [
            'create' => 'اضافة أقسام الإضافات',
            'index' => 'أقسام الإضافات',
            'update' => 'تعديل قسم الإضافات',
        ],
        'validation' => [
            'image' => [
                'required' => 'من فضلك اختر الصورة',
            ],
            'title' => [
                'required' => 'من فضلك ادخل العنوان',
                'unique' => 'هذا العنوان تم ادخالة من قبل',
            ],
            'color' => [
                'required_if' => 'من فضلك ادخل لون للقسم الرئيسى',
            ],
        ],
    ],
    'addon_options' => [
        'datatable' => [
            'created_at' => 'تاريخ الآنشاء',
            'date_range' => 'البحث بالتواريخ',
            'image' => 'الصورة',
            'options' => 'الخيارات',
            'price' => 'السعر',
            'title' => 'العنوان',
            'type' => 'النوع',
            'addon_category' => 'قسم الإضافة',
        ],
        'form' => [
            'image' => 'الصورة',
            'status' => 'الحالة',
            'price' => 'السعر',
            'qty' => 'الكمية',
            'tabs' => [
                'general' => 'بيانات عامة',
            ],
            'title' => 'عنوان',
            'color' => 'اللون',
            'sort' => 'الترتيب',
            'unlimited' => 'كمية غير محدودة',
            'limited' => 'تحديد الكمية',
            'addon_category_id' => 'قسم الإضافة',
        ],
        'routes' => [
            'create' => 'اضافة الإضافات',
            'index' => 'الإضافات',
            'update' => 'تعديل الإضافات',
        ],
        'alert' => [
            'select_addon_category' => 'اختر قسم الإضافة',
        ],
        'validation' => [
            'image' => [
                'required' => 'من فضلك اختر الصورة',
            ],
            'title' => [
                'required' => 'من فضلك ادخل العنوان',
                'unique' => 'هذا العنوان تم ادخالة من قبل',
            ],
            'price' => [
                'numeric' => 'من فضلك ادخل السعر ارقام فقط',
                'min' => 'من فضلك ادخل السعر اكبر من صفر',
                'required' => 'من فضلك ادخل السعر',
            ],
            'qty' => [
                'numeric' => 'من فضلك ادخل الكمية ارقام فقط',
                'min' => 'من فضلك ادخل الكمية ارقام اكبر من صفر',
                'required' => 'من فضلك ادخل الكمية',
            ],
            'addon_category_id' => [
                'required' => 'من فضلك اختر قسم الإضافة',
                'exists' => 'هذا القسم غير موجود',
            ],
            'addon_options' => [
                'required' => 'من فضلك ادخل إضافات القسم',
                'array' => 'إضافات القسم يجب ان تكون من نوع مصفوفة',
                'min' => 'إضافات القسم يجب ان تحتوى على عنصر واحد على الاقل',
            ],
        ],
    ],
    'home_categories' => [
        'datatable' => [
            'created_at' => 'تاريخ الآنشاء',
            'date_range' => 'البحث بالتواريخ',
            'image' => 'الصورة',
            'options' => 'الخيارات',
            'status' => 'الحالة',
            'title' => 'العنوان',
        ],
        'form' => [
            'image' => 'الصورة',

            'status' => 'الحالة',
            'tabs' => [
                'general' => 'بيانات عامة',
            ],
            'title' => 'عنوان',
            'sort' => 'الترتيب',
        ],
        'routes' => [
            'create' => 'اضافة اقسام الصفحة الرئيسية',
            'index' => 'اقسام الصفحة الرئيسية',
            'update' => 'تعديل قسم الصفحة الرئيسية',
        ],
        'validation' => [

            'image' => [
                'required' => 'من فضلك اختر الصورة',
            ],
            'title' => [
                'required' => 'من فضلك ادخل العنوان',
                'unique' => 'هذا العنوان تم ادخالة من قبل',
            ],

        ],
    ],
];
