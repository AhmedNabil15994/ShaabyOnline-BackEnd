<?php

return [
    'slider' => [
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'end_at' => 'End at',
            'image' => 'Image',
            'link' => 'Link',
            'options' => 'Options',
            'start_at' => 'Start at',
            'status' => 'Status',
            'type' => 'Type',
        ],
        'form' => [
            'end_at' => 'End at',
            'image' => 'Image',
            'link' => 'Link',
            'start_at' => 'Start at',
            'status' => 'Status',
            'title' => 'Title',
            'short_description' => 'Short Description',
            'tabs' => [
                'general' => 'General Info.',
            ],
            'products' => 'Products',
            'categories' => 'Categories',
            'vendors' => 'Vendors',
            'slider_type' => [
                'label' => 'Link Type',
                'external' => 'External',
                'product' => 'Product',
                'category' => 'Category',
                'vendor' => 'Vendor',
            ],
        ],
        'alert' => [
            'select_products' => 'Select Product',
            'select_categories' => 'Select Category',
            'select_vendors' => 'Select Vendor',
        ],
        'routes' => [
            'create' => 'Create slider images',
            'index' => 'slider images',
            'update' => 'Update slider images',
        ],
        'validation' => [
            'end_at' => [
                'required' => 'Please select slider image ent at',
            ],
            'image' => [
                'required' => 'Please select image of the slider image',
            ],
            'link' => [
                'required' => 'Please add the link of slider image',
                'required_if' => 'Please add the link of slider image',
            ],
            'start_at' => [
                'required' => 'Please select the date of started slider image',
            ],
            'title' => [
                'required' => 'Please add the title of slider',
            ],
            'slider_type' => [
                'required' => 'Please select the type of slider',
                'in' => 'This type of slider must be in',
            ],
            'product_id' => [
                'required_if' => 'Please select the product',
            ],
            'category_id' => [
                'required_if' => 'Please select the category',
            ],
            'vendor_id' => [
                'required_if' => 'Please select the vendor',
            ],
        ],
    ],
];
