<?php

return [
    'order_statuses' => [
        'datatable' => [
            'color_label' => 'Label Color',
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'failed_status' => 'Failed Order Status',
            'label_color' => 'Label Color',
            'options' => 'Options',
            'success_status' => 'Success Order Status',
            'title' => 'Title',
        ],
        'index' => [
            'title' => 'Order Statuses',
        ],
        'form' => [
            'color_label' => 'Label Color',
            'failed_status' => 'Failed Order Status',
            'label_color' => 'Label Color',
            'success_status' => 'Success Order Status',
            'is_success' => 'Order Status Type',
            'success' => 'Success',
            'failed' => 'Failed',
            'other_wise' => 'Other Wise',
            'tabs' => [
                'general' => 'General Info.',
            ],
            'create' => [
                'title' => 'Create Order Status',
            ],
            'update' => [
                'title' => 'Update Order Status',
            ],
            'title' => 'Title',
        ],
        'routes' => [
            'create' => 'Create Order Statuses',
            'index' => 'Order Statuses',
            'update' => 'Update Order Statuses',
        ],
        'validation' => [
            'color_label' => [
                'required' => 'Please enter the color of label for this status',
            ],
            'label_color' => [
                'required' => 'Please enter the color of label for this status',
            ],
            'title' => [
                'required' => 'Please enter the title of order status',
                'unique' => 'This title order status is taken before',
            ],
            'is_success' => [
                'required' => 'Please choose the type of order status',
                'in' => 'The type of order status in 0,1',
            ],
        ],
    ],
    'orders' => [
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'method' => 'Payment Method',
            'options' => 'Options',
            'shipping' => 'Shipping',
            'status' => 'Status',
            'subtotal' => 'Subtotal',
            'total' => 'Total',
            'state' => 'State',
        ],
        'index' => [
            'title' => 'Orders',
        ],
        'all_orders' => [
            'title' => 'All Transactions',
        ],
        'show' => [
            'address' => [
                'block' => 'Block',
                'building' => 'Building',
                'city' => 'City',
                'data' => 'Address info.',
                'state' => 'State',
                'street' => 'Street',
                'details' => 'Street',
                'civil_id' => 'Civil ID',
                'receiver_name' => 'Receiver Name',
                'receiver_mobile' => 'Receiver Mobile',
                'district' => 'Avenue',
                'flat' => 'Flat',
                'floor' => 'Floor',
                'governorate' => 'Governorate',
            ],
            'drivers' => [
                'title' => 'Drivers',
                'assign' => 'Assign to driver',
                'no_drivers' => 'There are currently no drivers',
            ],
            'status' => 'Order Status',
            'notes' => 'Notes',
            'order_notes' => 'Order Notes',
            'edit' => 'Edit Order Status',
            'invoice' => 'Invoice',

            'refund_btn' => 'Refund',
            'refund' => 'Refund',
            'close' => 'Close',
            'return' => 'Return',
            'product' => 'Product(s)',
            'refund_validation' => [
                'large_qty_than_item_qty' => 'Asked Qty larger than item Qty ::product',
            ],
            'order_history_log' => 'History Log',
            'admin_note' => 'Admin Note',
            'confirm_payment' => 'Confirm Payment',
            'confirm_payment_dec' => ' Are you sure to confirm the payment?',

            'invoice_customer' => 'Customer Invoice',
            'invoice_details' => 'Order Details',
            'change_order_status' => 'Change Order Status',
            'delivery_time_note' => 'Delivery Note',

            'payment_confirmed_at' => 'Payment confirmed in',

            'items' => [
                'qty_stock' => 'Stock Qty',
                'remain' => 'Remain',
                'refund_qty' => 'Return Qty',
                'data' => 'Items',
                'options' => 'Options',
                'price' => 'Price',
                'qty' => 'Qty',
                'title' => 'Title',
                'total' => 'Total',
                'notes' => 'Notes',
                'coupon_discount' => 'Coupon Discount',
                'image' => 'Image',
                'gifts' => [
                    'index' => 'Gifts',
                    'no_available_gifts' => '---',
                    'title' => 'Title',
                    'price' => 'Price',
                    'products' => 'Gift Products',
                ],
                'cards' => [
                    'index' => 'Cards',
                    'no_available_cards' => '---',
                    'title' => 'Title',
                    'price' => 'Price',
                    'sender_name' => 'Sender',
                    'receiver_name' => 'Receiver',
                    'message' => 'Message',
                ],
                'addons' => [
                    'index' => 'AddOns',
                    'no_available_addons' => '---',
                    'title' => 'Title',
                    'price' => 'Price',
                    'qty' => 'Quantity',
                ],
                'companies' => [
                    'index' => 'Shipping Companies',
                    'name' => 'Name',
                    'availabilities' => 'Delivery Date',
                    'delivery' => 'Delivery Price',
                    'vendor' => 'Vendor',
                ],
            ],
            'order' => [
                'data' => 'Order info.',
                'off' => 'Discount',
                'shipping' => 'Shipping',
                'subtotal' => 'Subtotal',
                'total' => 'Total',
                'coupon_discount' => 'Coupon Discount',
            ],
            'other' => [
                'data' => 'Order Additional info.',
                'total_comission' => 'Commission from vendor',
                'total_profit' => 'Cost Price Profit',
                'total_profit_comission' => 'Total Profit',
                'vendor' => 'Vendor',
            ],
            'title' => 'Show Order',
            'user' => [
                'data' => 'Customer Info.',
                'email' => 'Email',
                'mobile' => 'Mobile',
                'username' => 'Username',
            ],
            'order_history' => [
                'title' => 'Order History',
                'updated_by' => 'Updated By',
                'order_status' => 'Order Status',
                'date' => 'Date/Time',
                'btn_delete' => 'Delete',
            ],
            'delivery_time' => [
                'day' => 'Delivery Day',
                'time' => 'Delivery Time',
                'type' => 'Delivery mechanism',
                'direct' => 'Direct',
                'schedule' => 'Schedule',
                'message' => 'Message',
            ],
            'vendors' => [
                'header_title' => 'Vendors',
                'image' => 'Image',
                'title' => 'Title',
            ],
        ],
        'notification' => [
            'title' => 'Order status changed',
            'body' => 'You order has been',
            'new_order_title' => 'New Order',
            'new_order_body' => 'You have new order',
        ],
        'create' => [
            'title' => 'Create New Order',
            'info' => 'Order Info',
            'tabs' => [
                'products' => 'Products',
                'user_info' => 'User Info',
            ],
            'btn' => [
                'save' => 'Save Order',
            ],
            'form' => [
                'products' => 'Products',
                'select_products' => '--- Select Products ---',
                'users' => 'Clients',
                'select_order_user' => '--- Select Order Client ---',
                'address_info' => 'Order Address',
                'address' => [
                    '' => '',
                ],
            ],
        ],
        'flags' => [
            'current_orders' => 'Current Orders',
            'all_orders' => 'All Orders',
            'completed_orders' => 'Completed Orders',
            'not_completed_orders' => 'Not Completed Orders',
            'refunded_orders' => 'Refunded Orders',
        ],
        'completed_orders' => [
            'title' => 'Completed Orders',
        ],
        'not_completed_orders' => [
            'title' => 'Not Completed Orders',
        ],
        'refunded_orders' => [
            'title' => 'Refunded Orders',
        ],
    ],
    'order_drivers' => [
        'validation' => [
            'user_id' => [
                'required' => 'Please, select driver',
                'exists' => 'This driver is not found now',
            ],
            'order_status' => [
                'required' => 'Please, select order status',
                'exists' => 'Order status is not found now',
            ],
        ],
    ],
];
