<?php

return [
    'brands' => [
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'image' => 'Image',
            'options' => 'Options',
            'status' => 'Status',
            'title' => 'Title',
        ],
        'form' => [
            'image' => 'Image',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'status' => 'Status',
            'tabs' => [
                'general' => 'General Info.',
                'seo' => 'SEO',
            ],
            'title' => 'Title',
        ],
        'routes' => [
            'create' => 'Create Brands',
            'index' => 'Brands',
            'update' => 'Update Brand',
        ],
        'validation' => [
            'image' => [
                'required' => 'Please select image',
            ],
            'title' => [
                'required' => 'Please enter the title',
                'unique' => 'This title is taken before',
            ],
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
            ],
            'title' => 'Title',
            'color' => 'Color',
            'sort' => 'Sort',
            'color_hint' => 'Hex Color - example: FFFFFF',
        ],
        'routes' => [
            'create' => 'Create Categories',
            'index' => 'Categories',
            'update' => 'Update Category',
        ],
        'validation' => [
            'category_id' => [
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
    'products' => [
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'image' => 'Image',
            'options' => 'Options',
            'status' => 'Status',
            'title' => 'Title',
            'vendor' => 'Vendor',
            'price' => 'Price',
            'qty' => 'Qty',
            'categories' => 'Categories',
            'product_flag' => 'Product Type',
        ],
        'form' => [
            "import_photos" => "Import photos",
            'arrival_end_at' => 'New Arrival End At',
            'arrival_start_at' => 'New Arrival Start At',
            'arrival_status' => 'New Arrival Status',
            'brands' => 'Product Brand',
            'cost_price' => 'Cost Price',
            'description' => 'Description',
            'short_description' => 'Short Description',
            'end_at' => 'Offer End At',
            "new_add" => "New Add",
            "empty_options" => "Empty Options",
            'image' => 'Image',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'offer' => 'Product Offer',
            'offer_price' => 'Offer Price',
            'offer_status' => 'Offer Status',
            "width" => "Width",
            "height" => "Height",
            "weight" => "Weight",
            "length" => "Length",
            "shipment" => "Shipment",
            "tags" => "Product Tags",
            "add_variations" => "Add Variations",
            'product_flag' => 'Product Type',
            'single' => 'Single',
            'variant' => 'Variant',
            'is_new' => 'Is New',

            'options' => 'Options',
            'percentage' => 'Percentage',
            'price' => 'Price',
            'qty' => 'Qty',
            'sku' => 'SKU',
            'start_at' => 'Offer Start At',
            'main_products' => 'Product',
            'status' => 'Status',
            'featured' => 'Featured',
            'browse_image' => 'Browse',
            'btn_add_more' => 'Add More',
            'vendor' => 'Vendor',
            'created_at' => 'Created At',
            'pending_for_approval' => 'Product approval',
            'sort' => 'Sort',
            "home_categories" => "Home Categories",

            'offer_type' => [
                'label' => 'Type',
                'amount' => 'Amount',
                'percentage' => 'Percentage',
            ],

            'import_selects' => [
                'title_ar' => 'Arabic Title',
                'title_en' => 'English Title',
                'price' => 'Price',
                'description_ar' => 'Arabic Description',
                'description_en' => 'English Description',
                'qty' => 'Qty',
                'sku' => 'SKU',
                'status' => 'Status',
                'category' => 'Category',
                'offer_price' => 'Offer Price',
                'offer_start_at' => 'Offer Start at',
                'offer_end_at' => 'Offer End at',
                'international_code' => 'International Code',
            ],

            'tabs' => [
                'export' => 'Export Products',
                'categories' => 'Product Categories',
                'gallery' => 'Image Gallery',
                'general' => 'General Info.',
                'new_arrival' => 'New Arrival',
                'seo' => 'SEO',
                'stock' => 'Stock & Price',
                'variations' => 'Variations',
                'add_ons' => 'Add Ons',
                'edit_add_ons' => 'Edit Add Ons',
                "shipment" => "Extra Information",
                "input_lang" => "Data :lang",
                "images" => "Additional / More Images",
                "tags" => "Product Tags",
                'search_keywords' => 'Search Keywords',
            ],
            'title' => 'Title',
            'vendors' => 'Product Vendor',
            'add_ons' => [
                'title' => 'Addon',
                'product' => 'Product',
                'name' => 'Name',
                'type' => 'Type',
                'single' => 'Single Select',
                'multiple' => 'Multi Select',
                'option' => 'Option',
                'price' => 'Price',
                'qty' => 'Qty',
                'image' => 'Image',
                'default' => 'Default',
                'add_more' => 'Add More',
                'save_options' => 'Save',
                'add_ons_name' => 'Add Ons Name',
                'show' => 'Show',
                'delete' => 'Delete',
                'reset_form' => 'Reset Form',
                'customer_can_select_exactly' => 'CUSTOMER CAN SELECT EXACTLY',
                'options_count' => 'Options Count',
                'min_options_count' => 'Min Options',
                'max_options_count' => 'Max Options',
                'created_at' => 'Created At',
                'operations' => 'Operations',
                'clear_defaults' => 'Clear Defaults',
                'confirm_msg' => 'Are you sure ?',
                'at_least_one_field' => 'At least one field is required',
                'options_count_greater_than_rows' => 'The number of customer choices should be less than the total choices',
                'loading' => 'Loading ...',
                'is_required' => 'Required',
            ],

            'unlimited' => 'Unlimited Quantity',
            'limited' => 'Limited Quantity',
        ],
        'routes' => [
            'clone' => 'Clone & Create Product',
            'create' => 'Create Products',
            'index' => 'Products',
            'update' => 'Update Product',
            'add_ons' => 'Add Ons',
            'review_products' => 'Review Products',
            'show' => 'Product Details',
        ],
        'validation' => [
            'select_option_values' => 'Please, Select option values',
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
            'offer_type' => [
                'in' => 'Offer type must be within these types',
                'required' => 'Please choose the offer type',
            ],
            'offer_price' => [
                'numeric' => 'Please enter the offer price as numeric only',
                'required' => 'Please enter the offer price',
            ],
            'offer_percentage' => [
                'numeric' => 'Please enter the offer percentage price as numeric only',
                'required' => 'Please enter the offer percentage price',
            ],
            'price' => [
                'numeric' => 'Please enter the price as numeric only',
                'required' => 'Please enter the price',
            ],
            'qty' => [
                'numeric' => 'Please enter the quantity as numeric only',
                'min' => 'Please enter the quantity as numeric greater than',
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
            'image' => [
                'required' => 'Pleas select image',
                'image' => 'Image file should be an image',
                'mimes' => 'Image must be in',
                'max' => 'The image size should not be more than',
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
            'images' => [
                'mimes' => 'File is not supported as image type',
                'max' => 'Image size is greater than 1 Mg',
            ],
            'tags' => [
                'array' => 'Tags field should be in array type',
            ],
            'search_keywords' => [
                'array' => 'Search keywords field should be in array type',
            ],
        ],
    ],
    'search_keywords' => [
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'image' => 'Image',
            'options' => 'Options',
            'status' => 'Status',
            'title' => 'Title',
        ],
        'form' => [
            'description' => 'Description',
            'short_description' => 'Short Description',
            'status' => 'Status',
            'title' => 'Title',
            'tabs' => [
                'export' => 'Export Search Keywords',
                'general' => 'General Info.',
                'seo' => 'SEO',
                "input_lang" => "Data :lang",
            ],
        ],
        'routes' => [
            'clone' => 'Clone & Create Search Keyword',
            'create' => 'Create Search Keywords',
            'index' => 'Search Keywords',
            'update' => 'Update Search Keyword',
            'show' => 'Search Keyword Details',
        ],
        'validation' => [
            'title' => [
                'required' => 'Please enter the title',
                'unique' => 'This title is taken before',
            ],
        ],
    ],
    'addon_categories' => [
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'image' => 'Image',
            'options' => 'Options',
            'status' => 'Status',
            'title' => 'Title',
            'type' => 'Type',
            'sort' => 'Sort',
        ],
        'form' => [
            'image' => 'Image',
            'status' => 'Status',
            'tabs' => [
                'general' => 'General Info.',
            ],
            'title' => 'Title',
            'color' => 'Color',
            'sort' => 'Sort',
            'color_hint' => 'Hex Color - example: FFFFFF',
        ],
        'routes' => [
            'create' => 'Create Addon Categories',
            'index' => 'Addon Categories',
            'update' => 'Update Addon Category',
        ],
        'validation' => [
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
    'addon_options' => [
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'image' => 'Image',
            'options' => 'Options',
            'price' => 'Price',
            'title' => 'Title',
            'type' => 'Type',
            'addon_category' => 'Addon Category',
        ],
        'form' => [
            'image' => 'Image',
            'status' => 'Status',
            'price' => 'Price',
            'qty' => 'Quantity',
            'tabs' => [
                'general' => 'General Info.',
            ],
            'title' => 'Title',
            'color' => 'Color',
            'sort' => 'Sort',
            'unlimited' => 'Unlimited Quantity',
            'limited' => 'Limited Quantity',
            'addon_category_id' => 'Addon Category',
        ],
        'alert' => [
            'select_addon_category' => 'Select Addon Category',
        ],
        'routes' => [
            'create' => 'Create Addons',
            'index' => 'Addons',
            'update' => 'Update Addons',
        ],
        'validation' => [
            'image' => [
                'required' => 'Please select image',
            ],
            'title' => [
                'required' => 'Please enter the title',
                'unique' => 'This title is taken before',
            ],
            'price' => [
                'numeric' => 'Please enter the price as numeric only',
                'min' => 'Please enter the price greater than zero',
                'required' => 'Please enter the price',
            ],
            'qty' => [
                'numeric' => 'Please enter the quantity as numeric only',
                'min' => 'Please enter the quantity as numeric greater than zero',
                'required' => 'Please enter the quantity',
            ],
            'addon_category_id' => [
                'required' => 'Please select Addon Category',
                'exists' => 'This category is not exist.',
            ],
            'addon_options' => [
                'required' => 'Please select Category Addons',
                'array' => 'Category addons must be of an array type',
                'min' => 'Category addons must contain at least one element',
            ],
        ],
    ],
    'home_categories' => [
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
            'status' => 'Status',
            'tabs' => [
                'general' => 'General Info.',
            ],
            'title' => 'Title',
            'sort' => 'Sort',
        ],
        'routes' => [
            'create' => 'Create Home Categories',
            'index' => 'Home Categories',
            'update' => 'Update Home Category',
        ],
        'validation' => [
            'image' => [
                'required' => 'Please select image',
            ],
            'title' => [
                'required' => 'Please enter the title',
                'unique' => 'This title is taken before',
            ],
        ],
    ],
];
