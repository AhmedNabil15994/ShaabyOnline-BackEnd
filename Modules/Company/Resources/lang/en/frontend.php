<?php

return [
    'address'   => [
        'btn'           => [
            'add'           => 'Add address',
            'add_modal'     => 'Add New Address',
            'go_to_payment' => 'Continue Order',
        ],
        'form'          => [
            'address_details'   => 'Address Details',
            'block'             => 'Block Number',
            'as_guest'          => 'Order As Guest',
            'as_member'         => 'Order As Member',
            'building'          => 'Building Number',
            'login'             => 'Login',
            'register'          => 'Register',
            'email'             => 'E-mail address',
            'optional_email'    => 'Optional E-mail address',
            'mobile'            => 'Mobile',
            'states'            => 'Chose State',
            'street'            => 'Street',
            'username'          => 'Username',
            'civil_id'          => 'Civil ID',
            'search_by_city'          => 'Search by city',
            'search_by_area'          => 'Search by area',
        ],
        'index'         => [
            'subtotal'  => 'Subtotal',
            'areas'     => 'Areas',
        ],
        'list'          => [
            'address_details'   => 'Address Details',
            'block'             => 'Block',
            'mobile'            => 'Mobile',
            'state'             => 'State',
            'street'            => 'Street',
            'username'          => 'Username',
        ],
        'title'         => 'Order Address',
        'validation'    => [
            'address'   => [
                'numeric'   => 'Please select the order address',
                'required'  => 'Please select the order address',
            ],
        ],
    ],
    'addresses' => [
        'form'  => [
            'kuwait'    => 'Kuwait',
        ],
    ],
    'cart'      => [
        'add_successfully'   => 'Item added successfully to shopping cart',
        'address_choosing_successfully'   => 'Area selected successfully',
        'btn'               => [
            'continue'              => 'Continue Shopping',
            'got_to_shopping_cart'  => 'Go to shopping cart',
            'ok'                    => 'Ok',
            'add'                   => 'Add',
            'remove_coupon'         => 'Remove Coupon',
        ],
        'cart_updated'      => 'Your request is done successfully',
        'delete'            => 'Delete',
        'clear'             => 'Clear all',
        'clear_cart'        => 'Cart cleared successfully',
        'delete_item'       => 'Product deleted from cart',
        'empty'             => 'There is no products in your shopping cart',
        'error_in_cart'     => 'Opss! , please try again please.',
        'go_to_checkout'    => 'Continue Order',
        'shipping'          => 'Shipping',
        'delivery_shipping' => 'Shipping',
        'contact_info'      => 'Contact Info',
        'subtotal'          => 'Subtotal',
        'title'             => 'Shopping Cart',
        'total'             => 'Total',
        'no_delivery_charge_to_area'             => 'There is no delivery charge for this region',
        'add_discount_code'             => 'Add Discount Code',
        'enter_discount_number'         => 'Enter Discount Number',
    ],
    'checkout'  => [
        'address'       => [
            'btn'       => [
                'add'       => 'Add address',
                'add_modal' => 'Add New Address',
            ],
            'details'   => [
                'address'   => 'Address Details',
                'block'     => 'Block',
                'mobile'    => 'Mobile',
                'state'     => 'State',
                'street'    => 'Street',
            ],
            'form'      => [
                'address_details'   => 'Address Details',
                'block'             => 'Block Number',
                'building'          => 'Building Number',
                'email'             => 'E-mail address',
                'mobile'            => 'Mobile',
                'states'            => 'Chose State',
                'street'            => 'Street',
                'username'          => 'Username',
                'password'          => 'Password',
            ],
            'title'     => 'Order Address',
        ],
        'index'         => [
            'go_to_payment' => 'Make Order Now',
            'payments'      => 'Chose Payment',
            'title'         => 'Checkout',
            'notes'         => 'Notes',
        ],
        'shipping'      => 'Shipping',
        'subtotal'      => 'Subtotal',
        'title'         => 'Checkout',
        'total'         => 'Total',
        'validation'    => [
            'order_limit'   => 'Sorry you can not continue for check out from this vendor , you must chose products not less than :',
        ],
    ],
    'products'  => [
        'alerts'            => [
            'product_qty_less_zero' => 'Sorry this product is out of stock , try again later',
            'qty_more_than_max'     => 'Sorry , but you can not request more than :',
//            'vendor_not_match'      => 'You can not add this item before clear the cart of another vendor.',
            'vendor_not_match'      => 'It is not possible to order from another pharmacy',
            'vendor_is_busy'        => 'The pharmacy cannot be ordered in a busy or closed condition',
            'qty_is_not_active'        => 'The product is not active now, try again later',
            'add_ons_options_qty_more_than_max'        => 'Sorry this addOns option is out of stock , try again later: ',
            'add_ons_option_name'        => 'to this option :',
        ],
        'description'       => 'Description of product',
        'price'             => 'Product Price',
        'in_stock'          => 'In Stock',
        'related_products'  => 'Related Products',
        'sku'               => 'SKU',
        'validation'        => [
            'option_value'  => [
                'required'  => 'Please select',
            ],
            'qty'           => [
                'numeric'   => 'Please enter quantity with numeric only',
                'required'  => 'Please enter quantity of product',
            ],
        ],
        'add_notes'         => 'Add Notes',
        'add_ons_option_name'    => 'AddOns Option',
        'add_ons_option_price'    => 'AddOns Option Price',
    ],
    'search'    => [
        'index' => [
            'empty' => 'There is no products or vendor with your search key',
            'title' => 'Search Result',
        ],
    ],
    'contact_info' => [
        'index' => [
            'title' => 'Contact Info'
        ],
    ],
];
