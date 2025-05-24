<?php

return [
    'reports' => [
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'image' => 'Image',
            'options' => 'Options',
            'status' => 'Status',
            "vendor_id" => "Vendor",
            "all" => "All",
            "type" => "Type",
            "vendor_title" => "Vendor Title",
            "cashier" => "Cashier",
            "branch_id" => "Branch"


        ],
        "product_sales" => [
            "product" => "Product",
            "qty" => "Qty",
            "total" => "Total",
            "product_stock" => "Product stock ",
            "order_id" => "Order N.",
            "order_date" => "Order date",
            "price" => "Price unit",
            "type" => "Type",
            "vendor_title" => "Vendor Title"

        ],
        "product_stock" => [
            "product" => "Product",
            "qty" => "Qty",
            "out_qty" => "Total Paied Qty",
            "order_date" => "Created at ",
            "price" => "Price unit",
            "type" => "Type",
            "vendor_title" => "Vendor Title"

        ],
        "refund" => [
            "product" => "Product",
            "qty" => "Qty",
            "total" => "Total",
            "order_id" => "Order N.",
            "order_date" => "Order date",
            "price" => "Price unit",
            "type" => "Type",
            "vendor_title" => "Vendor Title"

        ],
        "order_sales" => [
            "vendors_count" => "Vendor Count",
            "qty" => "Qty",
            "total" => "Total",
            "order_id" => "Order N.",
            "order_date" => "Order date",
            "payment_method" => "Payment Method",
            "user" => "User",
            "cashier" => "Cashier",
            "discount" => "Discount",
        ]
        ,
        "vendors" => [
            "title" => "Vendor Title",

            "total" => "Total Sales",
            "total_refund" => "Total Refund",
            "qty_refund" => "Qty  Refund",
            "qty" => "َQty",
            "created_at" => "Created at",
        ],
        "order_refund" => [
            "vendors_count" => "Vendor Count",
            "qty" => "Qty",
            "total" => "Total",
            "order_id" => "Order N.",
            "order_date" => "Order date",
            "payment_method" => "Payment Method",
            "user" => "User",
            "cashier" => "Cashier",
        ],
        'routes' => [
            'product_sales' => 'Report Product Sales',
            'order_sales' => 'Report Order Sales',
            "refund" => "Report Refund Product Sales",
            "order_refund" => "Report Refund Orders",
            "product_stock" => "Product Stock Report",
            "vendors" => "Vendors Report"

        ],

    ],

];
