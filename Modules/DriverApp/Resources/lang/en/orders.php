<?php

return [
    'shipping_company' => [
        'validations' => [
            'availabilities' => [
                'day_code' => [
                    'required' => 'Enter shipping day code',
                ],
                'day' => [
                    'required' => 'Enter shipping day',
                ],
                'time_from' => [
                    'required' => 'Enter time from of shipping day',
                ],
                'time_to' => [
                    'required' => 'Enter time to of shipping day',
                ],
            ],
        ],
    ],
    'driver' => [
        'order_not_found' => 'This order is not found',
        'order_assigned_befor' => 'The order has been assigned to the driver',
        'oops_error' => 'Oops, Try again!',
        'you_have_pending_order' => 'Sorry, your order has not been delivered',
    ],
];
