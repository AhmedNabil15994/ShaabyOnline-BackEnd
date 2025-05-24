<?php

return [
    'products' => [
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'image' => 'Image',
            'options' => 'Options',
            'status' => 'Status',
            'title' => 'Title',
            'vendor' => 'Vendor',
        ],
        'form' => [
            'arrival_end_at' => 'New Arrival End At',
            'arrival_start_at' => 'New Arrival Start At',
            'arrival_status' => 'New Arrival Status',
            'brands' => 'Product Brand',
            'cost_price' => 'Cost Price',
            'short_description' => 'Short Description',
            'description' => 'Description',
            'end_at' => 'Offer End At',
            'image' => 'Image',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            "new_add" => "New Add",
            'offer' => 'Product Offer',
            'offer_price' => 'Offer Price',
            'offer_status' => 'Offer Status',
            'options' => 'Options',
            'percentage' => 'Percentage',
            'price' => 'Price',
            "width" => "Width",
            "height" => "Height",
            "weight" => "Weight",
            "length" => "Length",
            'qty' => 'Qty',
            'sku' => 'SKU',
            'start_at' => 'Offer Start At',
            'status' => 'Status',
            'featured' => 'Featured',
            "add_variations" => "Add Variations",
            'sort' => 'Sort',
            'is_new' => 'Is New',

            'offer_type' => [
                'label' => 'Type',
                'amount' => 'Amount',
                'percentage' => 'Percentage',
            ],

            'tabs' => [
                'categories' => 'Product Categories',
                'gallery' => 'Additional / More Images',
                'general' => 'General Info.',
                'new_arrival' => 'New Arrival',
                'seo' => 'SEO',
                'stock' => 'Stock & Price',
                'add_ons' => 'Add Ons',
                'edit_add_ons' => 'Edit Add Ons',
                'variations' => 'Variations',
                "shipment" => "Extra Informations",
            ],
            'title' => 'Title',
            'vendors' => 'Product Vendor',
            'add_ons' => [
                'name' => 'Name',
                'type' => 'Type',
                'single' => 'Single Select',
                'multiple' => 'Multi Select',
                'option' => 'Option',
                'price' => 'Price',
                'default' => 'Default',
                'add_more' => 'Add More',
                'save_options' => 'Save',
                'add_ons_name' => 'Add Ons Name',
                'show' => 'Show',
                'reset_form' => 'Reset Form',
                'customer_can_select_exactly' => 'CUSTOMER CAN SELECT EXACTLY',
                'options_count' => 'Options Count',
                'created_at' => 'Created At',
                'operations' => 'Operations',
                'clear_defaults' => 'Clear Defaults',
                'confirm_msg' => 'Are you sure ?',
                'at_least_one_field' => 'At least one field is required',
                'options_count_greater_than_rows' => 'The number of customer choices should be less than the total choices',
            ],
        ],
        'routes' => [
            'create' => 'Create Products',
            'index' => 'Products',
            'update' => 'Update Product',
            'add_ons' => 'Add Ons',
        ],
        'validation' => [
            'arrival_end_at' => [
                'date' => 'Please enter end at ( new arrival ) as date',
                'required' => 'Please enter end at ( new arrival )',
            ],
            'arrival_start_at' => [
                'date' => 'Please enter start at ( new arrival ) as date',
                'required' => 'Please enter end at ( new arrival )',
            ],
            'brand_id' => [
                'required' => 'Please select the brand',
            ],
            'category_id' => [
                'required' => 'Please select at least one category',
            ],
            'cost_price' => [
                'numeric' => 'Please enter the cost price as numeric only',
                'required' => 'Please enter the cost price',
            ],
            'end_at' => [
                'date' => 'Please enter end at ( offer ) as date',
                'required' => 'Please enter end at ( offer )',
            ],
            'image' => [
                'required' => 'Please select image',
            ],
            'offer_price' => [
                'numeric' => 'Please enter the offer price as numeric only',
                'required' => 'Please enter the offer price',
            ],
            'price' => [
                'numeric' => 'Please enter the price as numeric only',
                'required' => 'Please enter the price',
            ],
            'qty' => [
                'numeric' => 'Please enter the quantity as numeric only',
                'required' => 'Please enter the quantity',
            ],
            'sku' => [
                'required' => 'Please enter the SKU',
            ],
            "width" => [
                'required' => 'Please select the width',
                'numeric' => 'Please enter the width as numeric only',
            ],
            "length" => [
                'required' => 'Please select the length',
                'numeric' => 'Please enter the length as numeric only',
            ],
            "weight" => [
                'required' => 'Please select the weight',
                'numeric' => 'Please enter the weight as numeric only',
            ],
            "height" => [
                'required' => 'Please select the height',
                'numeric' => 'Please enter the height as numeric only',
            ],
            'start_at' => [
                'date' => 'Please enter start at ( offer ) as date',
                'required' => 'Please enter start at ( offer )',
            ],
            'title' => [
                'required' => 'Please enter the title',
                'unique' => 'This title is taken before',
            ],
            'variation_price' => [
                'required' => 'Please add price of variants',
            ],
            'variation_qty' => [
                'required' => 'Please add Quantity of variants',
            ],
            'variation_sku' => [
                'required' => 'Please add SKU of variants',
            ],
            'variation_status' => [
                'required' => 'Please select status of variants',
            ],
            'vendor_id' => [
                'required' => 'Please select the vendor',
            ],
            'add_ons' => [
                'option_name' => [
                    'required' => 'Please enter add ons name',
                ],
                'add_ons_type' => [
                    'required' => 'Please select add ons type',
                    'in' => 'Add ons type in',
                ],
                'price' => [
                    'required' => 'Please enter add ons options price',
                    'array' => 'Add ons price should be array',
                ],
                'rowId' => [
                    'required' => 'Please enter all add ons options ids',
                    'array' => 'Add ons Row IDs should be array',
                ],
                'option' => [
                    'required' => 'Please enter all add ons option\'s name',
                    'array' => 'Add ons options should be array',
                    'min' => 'At least One add ons option',
                ],
            ],
        ],
    ],
];
