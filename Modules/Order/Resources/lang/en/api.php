<?php

return [
    'orders' => [
        'validations' => [
            'order_not_found' => 'This order does not currently exist',
            'order_rated' => 'The order has been rated previously',
            'user_id' => [
                'required' => 'Enter user id',
                'exists' => 'This user does not currently exist',
                'does_not_match' => 'This user is not identical to the current user',
            ],
            'company_delivery_fees' => [
                'required' => 'Please, Select delivery state to get delivery price',
            ],
            'cart' => [
                'required' => 'Please, Add products to cart',
            ],
            'address_id' => [
                'required' => 'Please, Select state of delivery address',
            ],
            'shipping' => [
                'type' => [
                    'required' => 'Please select a delivery time type',
                ],
            ],
        ],
    ],
    'address' => [
        'validations' => [
            'address' => [
                'min' => 'Please add more details , must be more than 10 characters',
                'required' => 'Please add address details',
                'string' => 'Please add address details as string only',
            ],
            'block' => [
                'required' => 'Please enter the block',
                'string' => 'You must add only characters or numbers in block',
            ],
            'building' => [
                'required' => 'Please enter the building number / name',
                'string' => 'You must add only characters or numbers in building',
            ],
            'email' => [
                'email' => 'Email must be email format',
                'required' => 'Please add your email',
            ],
            'mobile' => [
                'digits_between' => 'You must enter mobile number with 8 digits',
                'min' => 'You must enter mobile number with 8 digits',
                'max' => 'You must enter mobile number with 8 digits',
                'numeric' => 'Please add mobile number as numbers only',
                'required' => 'Please add mobile number',
                'string' => 'Please add mobile as string only',
            ],
            'state' => [
                'numeric' => 'Please chose state',
                'required' => 'Please chose state',
            ],
            'state_id' => [
                'numeric' => 'Please chose state',
                'required' => 'Please chose state',
            ],
            'street' => [
                'required' => 'Please enter the street name / number',
                'string' => 'You must add only characters or numbers in street',
            ],
            'username' => [
                'min' => 'username must be more than 2 characters',
                'required' => 'Please add username',
                'string' => 'Please add username as string only',
            ],
            'address_type' => [
                'required' => 'Please, Choose Delivery Address Type',
                'in' => 'Delivery address type values must be included',
            ],
            'selected_address_id' => [
                'required' => 'Please, Choose Address From Previous Addresses',
                'not_found' => 'This address does not currently exist',
            ],
        ],
    ],
    'payment' => [
        'validations' => [
            'required' => 'Please Choose Payment Type',
            'in' => 'The type of payment method must be within:',
        ],
    ],
    'shipping_company' => [
        'validations' => [
            'day_code' => [
                'required' => 'Please Choose Shipping Day Code',
            ],
            'day' => [
                'required' => 'Please Choose Shipping Day',
            ],
        ],
    ],
    'product' => [
        'form' => [
            'product_id' => 'This product id',
        ],
        'validations' => [
            'not_found' => 'is not currently available',
            'qty_exceeded' => 'Required quantity is not available for the product',
            'has_variations' => 'This product contains other "Variations" products that cannot be ordered. You can order a product in it',
        ],
    ],
];
