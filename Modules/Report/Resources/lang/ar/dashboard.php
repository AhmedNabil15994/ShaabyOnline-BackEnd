<?php

return [
    'reports' => [
        'datatable' => [
            'created_at' => 'تاريخ الآنشاء',
            'date_range' => 'البحث بالتواريخ',
            'options' => 'الخيارات',
            'status' => 'الحالة',
            "vendor_id" => "المتجر",
            "all" => "الكل",
            "type" => "النوع",
            "cashier" => "الكاشير",
            "branch_id" => "الفرع"
        ],
        "product_sales" => [
            "product" => "اسم المنتج",
            "qty" => "الكميه",
            "total" => "الاجمالى",
            "product_stock" => "المخزون ",
            "order_id" => "رقم الطلب",
            "order_date" => " تاريح الطلب",
            "price" => "سعر القطعه",
            "type" => "النوع",
            "vendor_title" => "اسم المتجر"
        ],
        "product_stock" => [
            "product" => "اسم المنتج",
            "qty" => "الكميه",
            "total" => "اجمالى الكمية المباعة",
            "order_date" => " تاريح  الانشاء",
            "price" => "سعر القطعه",
            "type" => "النوع",
            "vendor_title" => "اسم المتجر"
        ],
        "order_sales" => [
            "vendors_count" => "عدد المتاجر فى الطلب",
            "qty" => "الكميه",
            "total" => "الاجمالى",
            "order_id" => "رقم الطلب",
            "order_date" => " تاريح الطلب",
            "payment_method" => "طريقة الدفع",
            "vendor_title" => "اسم المتجر",
            "branch_title" => "اسم الفرع",
            "from_cashier" => "POS",
            "discount" => "الخصم",
            "user" => "المستخدم",

        ],
        "refund" => [
            "product" => "اسم المنتج",
            "qty" => "الكميه",
            "total" => "الاجمالى",
            "product_stock" => "المخزون ",
            "order_id" => "رقم الطلب",
            "created_at" => " تاريح الطلب",
            "price" => "سعر القطعه",
            "type" => "النوع",
            "vendor_title" => "اسم المتجر"

        ],
        "vendors" => [
            "title" => "اسم المتجر",

            "total" => "اجمالى المبيعات",
            "total_refund" => "اجمالى  المرتجع",
            "qty_refund" => "اجمالى  الكميه المرتجعه",
            "qty" => "اجمالى الكميات فى المخزن",
            "created_at" => " تاريح الطلب",
        ],
        "order_refund" => [
            "vendors_count" => "عدد المتاجر فى الطلب",
            "qty" => "الكميه",
            "total" => "الاجمالى",
            "order_id" => "رقم الطلب",
            "order_date" => " تاريح الطلب",
            "payment_method" => "طريقة الدفع",
            "vendor_title" => "اسم المتجر"
        ],
        'routes' => [
            'product_sales' => 'تقارير المنتجات المباعة',
            "refund" => "تقارير المرجع",
            'order_sales' => 'تقارير الطلبات المباعة',
            "order_refund" => "تقارير مرتجعات الطلبات",
            "product_stock" => "تقارير مخزون المنتجات",
            "vendors" => "تقارير المتاجر",

        ],

    ],


];
