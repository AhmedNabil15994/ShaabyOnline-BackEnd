<?php

return [
    'tags' => [
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'image' => 'Image',
            'options' => 'Options',
            'status' => 'Status',
            'color' => 'Color',
            'title' => 'Title',
        ],
        'form' => [
            'arrival_end_at' => 'New Arrival End At',
            'arrival_start_at' => 'New Arrival Start At',
            'arrival_status' => 'New Arrival Status',
            'brands' => 'Tags Brand',
            'cost_price' => 'Cost Price',
            'description' => 'Description',
            'short_description' => 'Short Description',
            'end_at' => 'Offer End At',
            "new_add" => "New Add",
            "empty_options" => "Empty Options",
            'image' => 'Image',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'offer' => 'Tag Offer',
            'offer_price' => 'Offer Price',
            'offer_status' => 'Offer Status',
            "width" => "Width",
            "height" => "Height",
            "weight" => "Weight",
            "length" => "Length",
            'options' => 'Options',
            'percentage' => 'Percentage',
            'price' => 'Price',
            'qty' => 'Qty',
            'sku' => 'SKU',
            'start_at' => 'Offer Start At',
            'status' => 'Status',
            'color' => 'Font Color',
            'background' => 'Background Color',
            'tabs' => [
                'export' => 'Export Tags',
                'categories' => 'Tags Categories',
                'gallery' => 'Image Gallery',
                'general' => 'General Info.',
                'new_arrival' => 'New Arrival',
                'seo' => 'SEO',
                'stock' => 'Stock & Price',
                'variations' => 'Variations',
                'add_ons' => 'Add Ons',
                'edit_add_ons' => 'Edit Add Ons',
                "size" => "Size",
                "input_lang" => "Data :lang"
            ],
            'title' => 'Title',
            'vendors' => 'Tags Vendor',
        ],
        'routes' => [
            'clone' => 'Clone & Create Tags',
            'create' => 'Create Tags',
            'index' => 'Tags',
            'update' => 'Update Tag',
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
            'start_at' => [
                'date' => 'Please enter start at ( offer ) as date',
                'required' => 'Please enter start at ( offer )',
            ],
            'title' => [
                'required' => 'Please enter the title',
                'unique' => 'This title is taken before',
            ],
        ],
    ],
];
