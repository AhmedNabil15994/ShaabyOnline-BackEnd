<?php

return [
    'vendors'   => [
        'all_categories'        => 'All',
        'ask'                   => 'Ask Pharmacist',
//        'ask'                   => 'Ask Us',
        'ask_q'                 => [
            'alerts'    => [
                'send_question' => 'The question sent successfully',
            ],
            'btn'       => 'Send Question',
            'btn_send_question'       => 'Send Question',
            'email'     => 'Email',
            'mail'      => [
                'header'    => 'New Question',
                'subject'   => 'New Question',
            ],
            'name'      => 'Name',
            'question'  => 'Question',
            'title'     => 'Ask Us',
            'pharmacist_title'     => 'Ask Pharmacist',
        ],
        'based_on_area'         => 'Based on area',
        'btn'                   => [
            'filter'    => 'Filter',
        ],
        'charge_started'        => 'Delivery Charge Started from',
        'delivery_charge'       => 'Delivery Charge',
        'delivery_time'         => 'Delivery Time',
        'filter'                => [
            'a_to_z'            => 'A to Z',
            'charge_started'    => 'Delivery Charge Started from',
            'delivery_charge'   => 'Delivery Charge',
            'delivery_time'     => 'Delivery Time',
            'latest'            => 'Latest',
            'order_limit'       => 'Min. Order',
            'payment_accepted'  => 'Payments Accepted',
            'payments'          => 'Accepted Payments',
            'rating'            => 'Rating',
            'select_sorted_by'  => 'Select',
            'sorted_by'         => 'Sorted By',
            'title'             => 'Filter',
            'vendor_status'     => 'Status',
            'search_placeholder'=> 'What are you looking for?',
            'search_here'       => 'Search Here',
            'no_search_result'  => 'No Search Result',
        ],
        'filters'               => 'Filter Products',
        'filters_by_brands'     => 'Brands',
        'filters_by_categories' => 'Categories',
        'filters_by_range_price'=> 'Range Price',
        'new_product'           => 'New Arrival',
        'order_limit'           => 'Min. Order',
        'payments'              => 'Allowed Payments',
        'prescription'          => 'Prescription',
        'prescription_r'        => [
            'alerts'    => [
                'send_prescription' => 'The prescription sent successfully',
            ],
            'btn'       => 'Send Prescription',
            'email'     => 'Email',
            'image'     => 'Image',
            'mail'      => [
                'header'    => 'New Prescription',
                'subject'   => 'New Prescription',
            ],
            'name'      => 'Name',
            'rocheta'   => 'Rocheta',
            'title'     => 'Prescription',
        ],
        'product_details'       => 'Details',
        'section'               => [
            'based_on_area'     => 'Based on area',
            'charge_started'    => 'Delivery Charge Started from',
            'delivery_charge'   => 'Delivery Charge',
            'delivery_time'     => 'Delivery Time',
            'order_limit'       => 'Min. Order',
            'payments'          => 'Accepted Payments',
            'title'             => 'Section',
        ],
        'total_products'        => 'Products',
        'prescription_form'        => [
            'validation'    =>  [
                'name'  => [
                    'required'  => 'Please enter name',
                    'string'  => 'Name must be string',
                    'max'  => 'The name must not exceed 300 characters',
                ],
                'email'  => [
                    'required'  => 'Please enter email',
                    'email'  => 'E-mail must be email address',
                ],
                'image'  => [
                    'image'  => 'The file must be image',
                    'max'  => 'The image must not exceed 2 mb',
                ],
            ],
        ],
        'ask_question_form'        => [
            'validation'    =>  [
                'name'  => [
                    'required'  => 'Please enter name',
                    'string'  => 'Name must be string',
                    'max'  => 'The name must not exceed 300 characters',
                ],
                'email'  => [
                    'required'  => 'Please enter email',
                    'email'  => 'E-mail must be email address',
                ],
                'question'  => [
                    'required'  => 'Please enter the question',
                    'max'  => 'The question must not exceed 3000 characters',
                ],
            ],
        ],
    ],
];
