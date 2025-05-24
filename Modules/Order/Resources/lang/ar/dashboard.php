<?php

return [
    'order_statuses' => [
        'datatable' => [
            'color_label' => 'لون الحالة',
            'created_at' => 'تاريخ الآنشاء',
            'date_range' => 'البحث بالتواريخ',
            'failed_status' => 'حالة طلب غير ناجحة',
            'label_color' => 'لون الحالة',
            'options' => 'الخيارات',
            'success_status' => 'حالة طلب ناجحة',
            'title' => 'العنوان',
        ],
        'index' => [
            'title' => 'حالات الطلب',
        ],
        'form' => [
            'color_label' => 'لون الحالة',
            'failed_status' => 'حالة طلب غير ناجحة',
            'label_color' => 'لون الحالة',
            'success_status' => 'حالة طلب ناجحة',
            'is_success' => 'نوع حالة الطلب',
            'success' => 'ناجحة',
            'failed' => 'فاشلة',
            'other_wise' => 'لا شىء',
            'tabs' => [
                'general' => 'بيانات عامة',
            ],
            'create' => [
                'title' => 'إضافة حالة طلب',
            ],
            'update' => [
                'title' => 'تعديل حالة الطلب',
            ],
            'title' => 'عنوان الحالة',
        ],
        'routes' => [
            'create' => 'اضافة حالات الطلبات',
            'index' => 'حالات الطلبات',
            'update' => 'تعديل حالة الطلبات',
        ],
        'validation' => [
            'color_label' => [
                'required' => 'من فضلك اختر لون الحالة',
            ],
            'label_color' => [
                'required' => 'من فضلك اختر لون الحالة',
            ],
            'title' => [
                'required' => 'من فضلك ادخل عنوان الحالة',
                'unique' => 'هذا العنوان تم ادخالة من قبل',
            ],
            'is_success' => [
                'required' => 'من فضلك اختر نوع حالة الطلب',
                'in' => 'نوع حالة الطلب بين القيم: 0,1',
            ],
        ],
    ],
    'orders' => [
        'datatable' => [
            'created_at' => 'تاريخ الآنشاء',
            'date_range' => 'البحث بالتواريخ',
            'method' => 'طريقة الدفع',
            'options' => 'الخيارات',
            'shipping' => 'التوصيل',
            'status' => 'الحالة',
            'subtotal' => 'المجموع',
            'total' => 'المجموع الكلي',
            'state' => 'المنطقة',
        ],
        'index' => [
            'title' => 'الطلبات',
        ],
        'all_orders' => [
            'title' => 'جميع العمليات',
        ],
        'show' => [
            'address' => [
                'block' => 'القطعه',
                'building' => 'البنايه',
                'city' => 'المحافظة',
                'data' => 'بيانات عنوان التوصيل',
                'state' => 'المنطقة',
                'street' => 'الشارع',
                'details' => 'تفاصيل العنوان',
                'civil_id' => 'الرقم المدني',
                'receiver_name' => 'اسم المرسل إليه',
                'receiver_mobile' => 'هاتف المرسل إليه',
                'district' => 'الجاده',
                'flat' => 'الشقة',
                'floor' => 'الطابق',
                'governorate' => 'المحافظة',
            ],
            'drivers' => [
                'title' => 'السائقين',
                'assign' => 'اسناد الى سائق',
                'no_drivers' => 'لا يوجد سائقين حالياً',
            ],
            'status' => 'الحالة',
            'notes' => 'الملاحظات',
            'order_notes' => 'ملاحظات للعميل',
            'edit' => 'تعديل حالة الطلب',
            'invoice' => 'الفاتورة',

            'close' => 'إغلاق',
            'refund_btn' => 'استعادة المنتجات',
            'refund' => 'استعادة ',
            'return' => 'استعادة',
            'product' => 'منتج',
            'refund_validation' => [
                'large_qty_than_item_qty' => 'الكمية المطلوبة اكبر من كمية المنتج الحالية ::product',
            ],
            'order_history_log' => 'سجل العمليات',
            'admin_note' => 'ملاحظات علي الفاتوره',
            'confirm_payment' => 'تأكيد الدفع',
            'confirm_payment_dec' => ' هل أنت متأكد من تأكيد عملية الدفع؟ ',

            'invoice_customer' => 'فاتورة العميل',
            'invoice_details' => 'تفاصيل الطلب',
            'change_order_status' => 'تغيير حالة الطلب',
            'delivery_time_note' => 'ملاحظة التوصيل',

            'payment_confirmed_at' => 'تم تأكيد الدفع فى',

            'items' => [
                'qty_stock' => 'كمية المخزون',
                'remain' => 'المتاح في الطلب',
                'refund_qty' => 'الكمية المرتجعة',
                'data' => 'المنتجات',
                'options' => 'خيارات',
                'price' => 'السعر',
                'qty' => 'الكمية',
                'title' => 'اسم المنتج',
                'total' => 'المجموع',
                'notes' => 'ملاحظات',
                'image' => 'الصورة',
                'coupon_discount' => 'قيمة الخصم',
                'gifts' => [
                    'index' => 'الهدايا',
                    'no_available_gifts' => '---',
                    'title' => 'العنوان',
                    'price' => 'السعر',
                    'products' => 'منتجات الهدية',
                ],
                'cards' => [
                    'index' => 'الكروت',
                    'no_available_cards' => '---',
                    'title' => 'العنوان',
                    'price' => 'السعر',
                    'sender_name' => 'المرسل',
                    'receiver_name' => 'المرسل إليه',
                    'message' => 'الرسالة',
                ],
                'addons' => [
                    'index' => 'الإضافات',
                    'no_available_addons' => '---',
                    'title' => 'العنوان',
                    'price' => 'السعر',
                    'qty' => 'الكمية',
                ],
                'companies' => [
                    'index' => 'شركات الشحن',
                    'name' => 'الاسم',
                    'availabilities' => 'وقت التوصيل',
                    'delivery' => 'قيمة الشحن',
                    'vendor' => 'المتجر',
                ],
            ],
            'order' => [
                'data' => 'بيانات الطلب',
                'off' => 'الخصم',
                'shipping' => 'التوصيل',
                'subtotal' => 'المجموع',
                'total' => 'المجموع الكلي',
                'coupon_discount' => 'قيمة الخصم',
            ],
            'other' => [
                'data' => 'بيانات اضافية',
                'total_comission' => 'نسبة الربح من المتجر',
                'total_profit' => 'ربح الفرق ( الشراء و البيع )',
                'total_profit_comission' => 'مجموع الارباح',
                'vendor' => 'المتجر',
            ],
            'title' => 'عرض الطلب',
            'user' => [
                'data' => 'بيانات العميل',
                'email' => 'البريد الالكتروني',
                'mobile' => 'رقم الهاتف',
                'username' => 'اسم العميل',
            ],
            'order_history' => [
                'title' => 'مراجعة حالات الطلب',
                'updated_by' => 'تم التعديل بواسطة',
                'order_status' => 'حالة الطلب',
                'date' => 'الوقت/التاريخ',
                'btn_delete' => 'حذف',
            ],
            'delivery_time' => [
                'day' => 'يوم التوصيل',
                'time' => 'وقت التوصيل',
                'type' => 'آلية التوصيل',
                'direct' => 'مباشر',
                'schedule' => 'وقت محدد',
                'message' => 'الرسالة',
            ],
            'vendors' => [
                'header_title' => 'المتاجر',
                'image' => 'الصورة',
                'title' => 'العنوان',
            ],
        ],
        'notification' => [
            'title' => 'تم تغيير حالة الطلب',
            'body' => 'حالة طلبك',
            'new_order_title' => 'طلب جديد',
            'new_order_body' => 'لديك طلب جديد',
        ],
        'create' => [
            'title' => 'إنشاء طلب جديد',
            'info' => 'بيانات الطلب',
            'tabs' => [
                'products' => 'المنتجات',
                'user_info' => 'بيانات العميل',
            ],
            'btn' => [
                'save' => 'حفظ الطلب',
            ],
            'form' => [
                'products' => 'المنتجات',
                'select_products' => '--- اختر المنتجات ---',
                'users' => 'العملاء',
                'select_order_user' => '--- اختر عميل الطلب ---',
                'address_info' => 'عنوان التوصيل',
                'address' => [
                    '' => '',
                ],
            ],
        ],
        'flags' => [
            'current_orders' => 'الطلبات الحالية',
            'all_orders' => 'جميع الطلبات',
            'completed_orders' => 'الطلبات المكتملة',
            'not_completed_orders' => 'الطلبات غير المكتملة',
            'refunded_orders' => 'الطلبات المرتجعة',
        ],
        'completed_orders' => [
            'title' => 'الطلبات المكتملة',
        ],
        'not_completed_orders' => [
            'title' => 'الطلبات غير المكتملة',
        ],
        'refunded_orders' => [
            'title' => 'الطلبات المرتجعة',
        ],
    ],
    'order_drivers' => [
        'validation' => [
            'user_id' => [
                'required' => 'من فضلك اختر السائق',
                'exists' => 'هذا السائق غير موجود حاليا',
            ],
            'order_status' => [
                'required' => 'من فضلك اختر حالة الطلب',
                'exists' => 'حالة الطلب غير موجودة حاليا',
            ],
        ],
    ],
];
