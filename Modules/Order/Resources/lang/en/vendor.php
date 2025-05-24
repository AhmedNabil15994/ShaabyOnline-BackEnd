<?php

return [
    'order_statuses'    => [
        'datatable' => [
            'color_label'   => 'Label Color',
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'failed_status' => 'Failed Order Status',
            'label_color'   => 'Label Color',
            'options'       => 'Options',
            'success_status'=> 'Success Order Status',
            'title'         => 'Title',
        ],
        'form'      => [
            'color_label'   => 'Label Color',
            'failed_status' => 'Failed Order Status',
            'label_color'   => 'Label Color',
            'success_status'=> 'Success Order Status',
            'tabs'          => [
                'general'   => 'General Info.',
            ],
            'title'         => 'Title',
        ],
        'routes'    => [
            'create'    => 'Create Order Statuses',
            'index'     => 'Order Statuses',
            'update'    => 'Update Order Statuses',
        ],
        'validation'=> [
            'color_label'   => [
                'required'  => 'Please enter the color of label for this status',
            ],
            'label_color'   => [
                'required'  => 'Please enter the color of label for this status',
            ],
            'title'         => [
                'required'  => 'Please enter the title of order status',
                'unique'    => 'This title order status is taken before',
            ],
        ],
    ],
    'orders'            => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'options'       => 'Options',
            'shipping'      => 'Shipping',
            'subtotal'      => 'Subtotal',
            'total'         => 'Total',
        ],
        'index'     => [
            'title' => 'Orders',
        ],
        'show'      => [
            'address'           => [
                'block'     => 'Block',
                'building'  => 'Building',
                'city'      => 'City',
                'data'      => 'Address info.',
                'state'     => 'State',
                'street'    => 'Street',
            ],
            'edit'              => 'Edit Order Status',
            'invoice'           => 'Invoice',
            'invoice_customer'  => 'Customer Invoice',
            'items'             => [
                'data'      => 'Items',
                'options'   => 'Options',
                'price'     => 'Price',
                'qty'       => 'Qty',
                'title'     => 'Title',
                'total'     => 'Total',
            ],
            'order'             => [
                'data'      => 'Order info.',
                'off'       => 'Discount',
                'shipping'  => 'Shipping',
                'subtotal'  => 'Subtotal',
                'total'     => 'Total',
            ],
            'other'             => [
                'data'                      => 'Order Additional info.',
                'total_comission'           => 'Commission from vendor',
                'total_profit'              => 'Cost Price Profit',
                'total_profit_comission'    => 'Total Profit',
                'vendor'                    => 'Vendor',
            ],
            'title'             => 'Show Order',
            'user'              => [
                'data'      => 'Customer Info.',
                'email'     => 'Email',
                'mobile'    => 'Mobile',
                'username'  => 'Username',
            ],
        ],
    ],
];
