<?php

return [
    'rates'   => [
        'user_rate_before'          => 'Already rated',
        'user_not_have_order'       => 'This request is not affiliated with the user',
        'rated_successfully'        => 'The pharmacy has been successfully rated',
        'btnClose'                  => 'Close',
        'your_rate'                 => 'Your Rate',
        'rate_now'                  => 'Rate Now',
        'ratings'                   => 'Ratings',
        'validation'  => [
            'order_id'    => [
                'required' => 'Order id is required',
                'exists' => 'Order id is not existed in orders table',
            ],
            'rating'    => [
                'required' => 'Rating is required',
                'integer' => 'Rating must be integer',
                'between' => 'Rating value must be between 1 and 5',
            ],
            'comment'    => [
                'string' => 'Comment must be string',
                'max' => 'Comment must not exceed 1000 characters',
            ],
        ],
    ],
    'companies' =>  [
        'vendor_not_found_with_this_state'      =>  'This state is not found with this vendor',
    ],
    'vendors' =>  [
        'vendor_not_found' => 'This vendor is not found',
        'vendor_not_in_cart' => 'Delivery to the store is not available at the moment, please make sure that there are products in the basket',
        'company_not_in_cart' => 'The delivery company is currently not available, please make sure there are products in the cart',
        'vendor_statuses' => [
            'open' => 'Open',
            'closed' => 'Closed',
            'busy' => 'Busy',
        ],
    ],
];
