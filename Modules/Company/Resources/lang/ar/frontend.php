<?php

return [
    'address'   => [
        'btn'           => [
            'add'           => 'اضافة عنوان',
            'add_modal'     => 'اضافة عنوان جديد',
            'go_to_payment' => 'استكمال الطلب',
        ],
        'form'          => [
            'address_details'   => 'تفاصيل العنوان',
            'block'             => 'رقم القطعة',
            'as_member'         => 'استكمال كعضو',
            'building'          => 'رقم البناية',
            'as_guest'          => 'استكمال كزائر',
            'email'             => 'البريد',
            'optional_email'    => 'البريد اختيارى',
            'login'             => 'تسجيل دخول',
            'register'          => 'تسجيل كعضو جديد',
            'mobile'            => 'الموبايل',
            'states'            => 'اختر المنطقة',
            'street'            => 'الشارع',
            'username'          => 'المستخدم',
            'civil_id'          => 'رقم المدنى',
            'search_by_city'          => 'ابحث عن مدينة',
            'search_by_area'          => 'ابحث عن منطقة',
        ],
        'index'         => [
            'subtotal'  => 'المجموع',
            'areas'     => 'المناطق',
        ],
        'list'          => [
            'address_details'   => 'تفاصيل العنوان',
            'block'             => 'القطعة',
            'mobile'            => 'الهاتف',
            'state'             => 'المنطقة',
            'street'            => 'الشارع',
            'username'          => 'المستخدم',
        ],
        'title'         => 'عنوان الطلب',
        'validation'    => [
            'address'   => [
                'numeric'   => 'من فضلك اختر عنوان التوصيل',
                'required'  => 'من فضلك اختر عنوان التوصيل',
            ],
        ],
    ],
    'addresses' => [
        'form'  => [
            'kuwait'    => 'الكويت',
        ],
    ],
    'cart'      => [
        'add_successfully'   => 'تم اضافة المنتج بنجاح داخل السلة',
        'address_choosing_successfully'   => 'تم إختيار المنطقة بنجاح',
        'btn'               => [
            'continue'              => 'استكمال التسوق',
            'got_to_shopping_cart'  => 'الذهاب الى السلة',
            'ok'                    => 'خروج',
            'add'                   => 'إضافة',
            'remove_coupon'         => 'إزالة الكوبون',
        ],
        'cart_updated'      => 'تم طلبك بنجاح داخل السلة',
        'delete'            => 'حذف',
        'clear'             => 'حذف الكل',
        'clear_cart'        => 'تم تفريغ السلة بنجاح',
        'delete_item'       => 'تم حذف المنتج من السلة',
        'empty'             => 'لا يوجد منتجات في السلة',
        'error_in_cart'     => 'حدث خطا ما ، من فضلك حاول مره اخرى',
        'go_to_checkout'    => 'استكمال الطلب',
        'shipping'          => 'التوصيل',
        'delivery_shipping' => 'رسوم التوصيل',
        'contact_info'      => 'معلومات التواصل',
        'subtotal'          => 'المجموع',
        'title'             => 'السلة',
        'total'             => 'المجموع الكلي',
        'no_delivery_charge_to_area'             => 'لا يوجد قيمة شحن لهذه المنطقة',
        'add_discount_code'             => 'إضافة كود الخصم',
        'enter_discount_number'         => 'ادخل رقم الكوبون',
    ],
    'checkout'  => [
        'address'       => [
            'btn'       => [
                'add'       => 'اضافة عنوان',
                'add_modal' => 'اضافة عنوان جديد',
            ],
            'details'   => [
                'address'   => 'تفاصيل العنوان',
                'block'     => 'القطعة',
                'mobile'    => 'الهاتف',
                'state'     => 'المنطقة',
                'street'    => 'الشارع',
            ],
            'form'      => [
                'address_details'   => 'تفاصيل العنوان',
                'block'             => 'رقم القطعة',
                'building'          => 'رقم البناية',
                'email'             => 'البريد الإلكترونى',
                'mobile'            => 'الموبايل',
                'states'            => 'اختر المنطقة',
                'street'            => 'الشارع',
                'username'          => 'المستخدم',
                'password'          => 'كلمة المرور',
            ],
            'title'     => 'عنوان الطلب',
        ],
        'index'         => [
            'go_to_payment' => 'اتمام الطلب الآن',
            'payments'      => 'اختر طريقة الدفع',
            'title'         => 'اتمام الطلب',
            'notes'         => 'ملاحظات',
        ],
        'shipping'      => 'التوصيل',
        'subtotal'      => 'المجموع',
        'title'         => 'الدفع',
        'total'         => 'السعر الكلي',
        'validation'    => [
            'order_limit'   => 'نعتذر لك لعدم اتمام الدفع ، يجب الا يقل الطلب من هذا المتجر عن :',
        ],
    ],
    'products'  => [
        'alerts'            => [
            'product_qty_less_zero' => 'نعتذر هذا المنتج اصبح حاليا غير متاح ، حاول لاحقا',
            'qty_more_than_max'     => 'نعتذر لكن لا يمكنك طلب كمية اكثر من :',
//            'vendor_not_match'      => 'لا يمكن اضافة هذا المنتج قبل حذف جميع منتجات المتجر الاخر.',
            'vendor_not_match'      => 'لا يمكن الطلب من صيدليه اخرى',
            'vendor_is_busy'        => 'لا يمكن الطلب من الصيدليه فى حالة مشغول أو مغلق',
            'qty_is_not_active'        => 'المنتج غير مفعل الآن ، حاول مرة أخرى لاحقًا',
            'add_ons_options_qty_more_than_max'        => 'نعتذر لكن لا يمكنك طلب كمية اكثر من :',
            'add_ons_option_name'        => 'لهذه الإضافة :',
        ],
        'description'       => 'تفاصيل المنتج',
        'price'             => 'سعر المنتج',
        'related_products'  => 'منتجات ذات صلة',
        'sku'               => 'كود المنتج',
        'in_stock'          => 'الكمية المتاحة حاليا',
        'validation'        => [
            'option_value'  => [
                'required'  => 'من فضلك اختر',
            ],
            'qty'           => [
                'numeric'   => 'من فضلك ادخل الكمية ارقام انجيليزية فقط',
                'required'  => 'من فضلك ادخل كمية المنتج المرادة',
            ],
        ],
        'add_notes'         => 'إضافة تعليمات اخرى',
        'add_ons_option_name'    => 'اسم الإضافة',
        'add_ons_option_price'    => 'سعر الإضافة',
    ],
    'search'    => [
        'index' => [
            'empty' => 'لا يوجد منتجات او متاجر لكلمة البحث الخاصة بك',
            'title' => 'نتائج البحث',
        ],
    ],
    'contact_info' => [
        'index' => [
            'title' => 'إتمام الطلب'
        ],
    ],
];
