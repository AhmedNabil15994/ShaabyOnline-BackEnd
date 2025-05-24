<?php

return [
    'payments' => [
        'create' => [
            'form' => [
                'code' => 'Payment Code',
                'general' => 'General Info.',
                'image' => 'Image',
                'info' => 'Info.',
            ],
            'title' => 'Create Payments Methods',
        ],
        'datatable' => [
            'code' => 'Code',
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'image' => 'Image',
            'options' => 'Options',
        ],
        'index' => [
            'title' => 'Payments Methods',
        ],
        'update' => [
            'form' => [
                'code' => 'Payment Code',
                'general' => 'General info.',
                'image' => 'Image',
            ],
            'title' => 'Update Payment Method',
        ],
        'validation' => [
            'code' => [
                'required' => 'Please enter the code of payment method',
                'unique' => 'This code of payment is taken before',
            ],
            'image' => [
                'required' => 'Please enter the image of payment method',
            ],
        ],
    ],
    'sections' => [
        'create' => [
            'form' => [
                'description' => 'Description',
                'general' => 'General Info.',
                'info' => 'Info.',
                'meta_description' => 'Meta Description',
                'meta_keywords' => 'Meta Keywords',
                'seo' => 'SEO',
                'status' => 'Status',
                'title' => 'Title',
                'image' => 'Image',
            ],
            'title' => 'Create Vendors Sections',
        ],
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'options' => 'Options',
            'status' => 'Status',
            'title' => 'Title',
        ],
        'index' => [
            'title' => 'Vendors Sections',
        ],
        'update' => [
            'form' => [
                'description' => 'Description',
                'general' => 'General info.',
                'meta_description' => 'Meta Description',
                'meta_keywords' => 'Meta Keywords',
                'seo' => 'SEO',
                'status' => 'Status',
                'title' => 'Title',
                'image' => 'Image',
            ],
            'title' => 'Update Vendor Section',
        ],
        'validation' => [
            'description' => [
                'required' => 'Please enter the description of section',
            ],
            'title' => [
                'required' => 'Please enter the title of section',
                'unique' => 'This title section is taken before',
            ],
        ],
    ],
    'vendor_statuses' => [
        'create' => [
            'form' => [
                'accepted_orders' => 'Accpeting orders',
                'info' => 'Info.',
                'label_color' => 'Label Color',
                'title' => 'Title',
            ],
            'title' => 'Create Vendor Status',
        ],
        'datatable' => [
            'accepted_orders' => 'Accpeting orders',
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'label_color' => 'Label Color',
            'options' => 'Options',
            'title' => 'Title',
        ],
        'index' => [
            'title' => 'Vendor Status',
        ],
        'update' => [
            'form' => [
                'accepted_orders' => 'Accpeting orders',
                'general' => 'General info.',
                'label_color' => 'Label Color',
                'title' => 'Title',
            ],
            'title' => 'Update Vendor Status',
        ],
        'validation' => [
            'accepted_orders' => [
                'unique' => 'only one status can be accepted orders',
            ],
            'label_color' => [
                'required' => 'Please select the label color',
            ],
        ],
    ],
    'vendors' => [
        'create' => [
            'form' => [
                'commission' => 'Commission from vendor',
                'description' => 'Description',
                'fixed_commission' => 'Fixed Commission',
                'fixed_delivery' => 'Fixed Delivery Fees',
                'general' => 'General Info.',
                'image' => 'Image',
                'info' => 'Info.',
                'is_trusted' => 'Is Trusted',
                'meta_description' => 'Meta Description',
                'meta_keywords' => 'Meta Keywords',
                'order_limit' => 'Order Limit',
                'other' => 'Other Info.',
                'payments' => 'Allowed Payments',
                'products' => 'Exporting Products',
                'receive_prescription' => 'Receiving Prescriptions',
                'receive_question' => 'Receiving Questions',
                'sections' => 'Vendor Section',
                'sellers' => 'Vendor sellers',
                'seo' => 'SEO',
                'status' => 'Status',
                'title' => 'Title',
                'vendor_email' => 'Vendor Email',
                'vendor_statuses' => 'Vendor Status',
                'companies' => 'Shipping Companies',
                'companies_and_states' => 'Shipping',
                'states' => 'Please select the areas to be delivered to',
                'categories' => 'Categories',
                'mobile' => 'Mobile',
                'address' => 'Address',
                'busy' => 'Busy',
                'fixed_app_commission' => 'App Commission (Fixed)',
                'percentage_app_commission' => 'App Commission (Percentage %)',
                'delivery_time_types' => [
                    'title' => 'Delivery time mechanism',
                    'direct' => 'As soon as possible',
                    'schedule' => 'Schedule',
                    'direct_delivery_message' => 'Direct delivery message',
                ],
                'payment' => 'Payment Info',
                'is_new' => 'Latest Stores',
                'use_app_drivers' => 'Use App Drivers',
            ],
            'title' => 'Create Vendors',
        ],
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'image' => 'Image',
            'options' => 'Options',
            'status' => 'Status',
            'title' => 'Title',
            'products' => 'Products',
            'no_products_data' => 'There are no products currently',
            'total' => 'Total',
            'per_page' => 'Total Per Page',
        ],
        'index' => [
            'sorting' => 'Sorting Vendors',
            'title' => 'Vendors',
        ],
        'sorting' => [
            'title' => 'Sorting Vendors',
        ],
        'update' => [
            'form' => [
                'commission' => 'Commission from vendor',
                'description' => 'Description',
                'general' => 'General info.',
                'image' => 'Image',
                'info' => 'Info.',
                'is_trusted' => 'Is Trusted',
                'meta_description' => 'Meta Description',
                'meta_keywords' => 'Meta Keywords',
                'order_limit' => 'Order Limit',
                'other' => 'Other Info.',
                'payments' => 'Allowed Payments',
                'products' => 'Exporting Products',
                'receive_prescription' => 'Receiving Prescriptions',
                'receive_question' => 'Receiving Questions',
                'sections' => 'Vendor Section',
                'sellers' => 'Vendor sellers',
                'seo' => 'SEO',
                'status' => 'Status',
                'title' => 'Title',
                'vendor_email' => 'Vendor Email',
                'categories' => 'Categories',
                'mobile' => 'Mobile',
                'address' => 'Address',
                'busy' => 'Busy',
                'fixed_app_commission' => 'App Commission (Fixed)',
                'percentage_app_commission' => 'App Commission (Percentage %)',
                'delivery_time_types' => [
                    'title' => 'Delivery time mechanism',
                    'direct' => 'As soon as possible',
                    'schedule' => 'Schedule',
                    'direct_delivery_message' => 'Direct delivery message',
                ],
                'payment' => 'Payment Info',
                'is_new' => 'Latest Stores',
                'use_app_drivers' => 'Use App Drivers',
            ],
            'title' => 'Update Vendor',
        ],
        'validation' => [
            'commission' => [
                'numeric' => 'Please add commission as numeric only',
                'required' => 'Please add commission from vendor',
            ],
            'fixed_commission' => [
                'numeric' => 'Please add fixed commission as numeric only',
                'required' => 'Please add fixed commission from vendor',
            ],
            'description' => [
                'required' => 'Please enter the description of vendor',
            ],
            'fixed_delivery' => [
                'numeric' => 'Please enter the fixed delivery fees as numbers only',
                'required' => 'Please enter the fixed delivery fees.',
            ],
            'image' => [
                'required' => 'Pleas select image',
                'image' => 'Image file should be an image',
                'mimes' => 'Image must be in',
                'max' => 'The image size should not be more than',
            ],
            'months' => [
                'numeric' => 'Please enter the months as numbers only',
                'required' => 'Please enter the months of the package',
            ],
            'order_limit' => [
                'numeric' => 'Please enter the order limit numeric only - ex : 5.000',
                'required' => 'Please enter the order limit for this vendro ex : 5.000',
            ],
            'payments' => [
                'required' => 'Please select the allowed payments methods for this vendor',
            ],
            'price' => [
                'numeric' => 'Please enter the price numbers only',
                'required' => 'Please enter the price of package',
            ],
            'sections' => [
                'required' => 'Please select the section of vendor',
                'exists' => 'vendor section is not available now',
            ],
            'sellers' => [
                'required' => 'Please select the sellers of this vendor',
            ],
            'special_price' => [
                'numeric' => 'Please enter the special price numbers only',
            ],
            'title' => [
                'required' => 'Please enter the title of vendor',
                'unique' => 'This title vendor is taken before',
            ],
            'products' => [
                'ids' => [
                    'required' => 'Please select a list of options or at least select one',
                ],
            ],
            'vendor_category_id' => [
                'required' => 'Please select at least one category',
                'exists' => 'vendor category is not available now',
            ],
            'mobile' => [
                'digits_between' => 'Please add mobile number only 8 digits',
                'numeric' => 'Please enter the mobile only numbers',
                'required' => 'Please enter the mobile of admin',
                'unique' => 'This mobile is taken before',
            ],
        ],
        'products' => [
            'title' => 'Vendor Products',
            'table' => [
                'title' => 'Product Title',
                'quantity' => 'Quantity',
                'price' => 'Price',
                'status' => 'Status',
            ],
        ],
        'availabilities' => [
            'times' => 'Times',
            'days' => [
                'sat' => 'Saturday',
                'sun' => 'Sunday',
                'mon' => 'Monday',
                'tue' => 'Tuesday',
                'wed' => 'Wednesday',
                'thu' => 'Thursday',
                'fri' => 'Friday',
            ],
            'form' => [
                'time_from' => 'Time From',
                'time_to' => 'Time To',
                'time' => 'Time',
                'day' => 'Day',
                'for_day' => 'For Day',
                'time_status' => 'Time Status',
                'full_time' => 'Open 24 Hour',
                'custom_time' => 'Custom Time',
                'btn_add_more' => 'Add More',
                'at_least_one_element' => 'At Least One Element Is Required !!',
                'greater_than' => 'is greater than',
                'contain_duplicated_values' => 'Contains duplicate times',
            ],
        ],
        'tabs' => [
            "availabilities" => "Work Times",
            "delivery_times" => "Delivery Times",
            "show_delivery_times" => "Show Delivery Times",
        ],
        'payment' => [
            'charges' => 'charges value',
            'cc_charges' => 'cc charges value',
            'ibans' => 'IBAN',
            'fixed_app_commission' => 'Commission (Fixed)',
            'percentage_app_commission' => 'Commission (Percentage %)',
            'app_commission_tooltip' => 'The commission is deducted from the total of the products without delivery charges',
        ],
    ],
    'categories' => [
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'image' => 'Image',
            'options' => 'Options',
            'status' => 'Status',
            'title' => 'Title',
            'type' => 'Type',
        ],
        'form' => [
            'image' => 'Image',
            'cover' => 'Cover',
            'main_category' => 'Main Category',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'status' => 'Status',
            'show_in_home' => 'Show In Home',
            'tabs' => [
                'category_level' => 'Categories Tree',
                'general' => 'General Info.',
                'seo' => 'SEO',
                "input_lang" => "Data :lang",
            ],
            'title' => 'Title',
            'color' => 'Color',
            'sort' => 'Sort',
            'color_hint' => 'Hex Color - example: FFFFFF',
        ],
        'routes' => [
            'create' => 'Create Vendors Categories',
            'index' => 'Vendors Categories',
            'update' => 'Update Vendor Category',
        ],
        'validation' => [
            'vendor_category_id' => [
                'required' => 'Please select category level',
            ],
            'image' => [
                'required' => 'Please select image',
            ],
            'title' => [
                'required' => 'Please enter the title',
                'unique' => 'This title is taken before',
            ],
            'color' => [
                'required_if' => 'Please enter a color for the main category',
            ],
        ],
    ],
    'delivery_charges' => [
        'create' => [
            'form' => [
                'delivery' => 'Charge',
                'general' => 'General Info.',
                'info' => 'Info.',
                'state' => 'State',
                'company' => 'Company',
            ],
            'title' => 'Create Delivery Charges',
        ],
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'delivery' => 'Charge',
            'options' => 'Options',
            'state' => 'State',
            'vendor' => 'Vendor',
        ],
        'index' => [
            'title' => 'Delivery Charges',
        ],
        'update' => [
            'charge' => 'Delivery Charge',
            'form' => [
                'delivery' => 'Charge',
                'general' => 'General info.',
                'state' => 'State',
                'vendor' => 'Vendor',
            ],
            'time' => 'Delivery Time / Minutes',
            'min_order_amount' => 'Min Order Amount',
            'title' => 'Update Delivery Charges',
            'state' => 'State',
            'delivery_time' => 'Delivery Note',
            'delivery_price' => 'Delivery Price',
            'status' => 'Status',
            'btn' => [
                'copy' => 'Copy',
                'activate_all' => 'Activate All',
            ],
        ],
        'validation' => [
            'delivery' => [
                'numeric' => 'Please enter the delivery charge numbers only',
                'required' => 'Please enter the delivery charge',
                'array' => 'Delivery price should be array',
            ],
            'state' => [
                'numeric' => 'Please select the state numbers only',
                'required' => 'Please select the state',
                'array' => 'State should be array',
            ],
            'vendor' => [
                'numeric' => 'Please select the vendor numbers only',
                'required' => 'Please select the vendor',
            ],
            'company' => [
                'numeric' => 'Please select the company numbers only',
                'required' => 'Please select the company',
            ],
        ],
    ],
];
