<?php

return [
    'packages'      => [
        'create'    => [
            'form'  => [
                'description'       => 'Description',
                'general'           => 'General Info.',
                'info'              => 'Info.',
                'meta_description'  => 'Meta Description',
                'meta_keywords'     => 'Meta Keywords',
                'months'            => 'Months of package',
                'other'             => 'Package info.',
                'price'             => 'Price',
                'seo'               => 'SEO',
                'special_price'     => 'Special Price',
                'status'            => 'Status',
                'title'             => 'Title',
            ],
            'title' => 'Create Vendors Packages',
        ],
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'months'        => 'Months',
            'options'       => 'Options',
            'price'         => 'Price',
            'special_price' => 'Special Price',
            'status'        => 'Status',
            'title'         => 'Title',
        ],
        'index'     => [
            'title' => 'Vendors Packages',
        ],
        'update'    => [
            'form'  => [
                'description'       => 'Description',
                'general'           => 'General info.',
                'meta_description'  => 'Meta Description',
                'meta_keywords'     => 'Meta Keywords',
                'months'            => 'Months of package',
                'other'             => 'Package info.',
                'price'             => 'Price',
                'seo'               => 'SEO',
                'special_price'     => 'Special Price',
                'status'            => 'Status',
                'title'             => 'Title',
            ],
            'title' => 'Update Vendor Package',
        ],
        'validation'=> [
            'description'   => [
                'required'  => 'Please enter the description of package',
            ],
            'months'        => [
                'numeric'   => 'Please enter the months as numbers only',
                'required'  => 'Please enter the months of the package',
            ],
            'price'         => [
                'numeric'   => 'Please enter the price numbers only',
                'required'  => 'Please enter the price of package',
            ],
            'special_price' => [
                'numeric'   => 'Please enter the special price numbers only',
            ],
            'title'         => [
                'required'  => 'Please enter the title of package',
                'unique'    => 'This title package is taken before',
            ],
        ],
    ],
    'subscriptions' => [
        'create'    => [
            'form'  => [
                'general'   => 'General Info.',
                'info'      => 'Info.',
                'packages'  => 'Chose Package',
                'status'    => 'Status',
                'vendors'   => 'Chose Vendor',
            ],
            'title' => 'Create Subscriptions',
        ],
        'datatable' => [
            'created_at'        => 'Created At',
            'date_range'        => 'Search By Dates',
            'end_at'            => 'End At',
            'options'           => 'Options',
            'original_price'    => 'Original Price',
            'package'           => 'Package',
            'price'             => 'Final Pice',
            'start_at'          => 'Start At',
            'status'            => 'Status',
            'vendor'            => 'Vendor',
        ],
        'index'     => [
            'title' => 'Vendors Subscriptions',
        ],
        'update'    => [
            'form'  => [
                'end_at'            => 'End At',
                'general'           => 'General info.',
                'original_price'    => 'Original Price',
                'packages'          => 'Chose Package',
                'start_at'          => 'Start At',
                'status'            => 'Status',
                'total'             => 'Final Price',
                'vendors'           => 'Chose Vendor',
            ],
            'title' => 'Update Vendor Package',
        ],
        'validation'=> [
            'end_at'        => [
                'required'  => 'Please select end date of subscription',
            ],
            'package_id'    => [
                'required'  => 'Please chose package of subscription',
            ],
            'total'         => [
                'required'  => 'Please fill the final price',
            ],
            'vendor_id'     => [
                'required'  => 'Please chose vendor of subscription',
            ],
        ],
    ],
];
