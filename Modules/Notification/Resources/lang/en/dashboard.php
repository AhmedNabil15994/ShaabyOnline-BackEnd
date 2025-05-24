<?php

return [
    'notifications' => [
        'title' => 'Add general notifications to users',
        'send_btn' => 'Send',
        'form' => [
            'description' => 'Description',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'status' => 'Status',
            'title' => 'Title',
            'tabs' => [
                'general' => 'General Info.',
                'seo' => 'SEO',
            ],
            'name' => 'Send Notifications',
            'msg_title' => 'Message Title',
            'msg_title_placeholder' => 'Ex: view new products',
            'msg_body' => 'Message Content',
            'products' => 'Products',
            'categories' => 'Categories',
            'notification_type' => [
                'label' => 'Notification Type',
                'general' => 'General',
                'product' => 'Product',
                'category' => 'Category',
            ],
        ],
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'options' => 'Options',
            'status' => 'Status',
            'title' => 'Title',
            'added_by' => 'Added By',
            'body' => 'Body',
            'type' => 'Type',
        ],
        'routes' => [
            'create' => 'Create Notifications',
            'index' => 'General Notifications',
            'update' => 'Update Notification',
        ],
        'validation' => [
            'description' => [
                'required' => 'Please enter the description of notification',
            ],
            'title' => [
                'required' => 'Please enter the title of notification',
                'unique' => 'This title notification is taken before',
            ],
            'notification_type' => [
                'required' => 'Please select the type of notification',
                'in' => 'This type of notification must be in',
            ],
            'product_id' => [
                'required_if' => 'Please select the product',
            ],
            'category_id' => [
                'required_if' => 'Please select the category',
            ],
        ],
        'general' => [
            'message_sent_success' => 'Notification Sent Successfully',
            'no_tokens' => 'Tokens not found',
        ],
    ],
];
