<?php

return [
    'orders'        => [
        'show'  => [
            'transaction'   => [
                'auth'          => 'AUTH',
                'method'        => 'Payment Method',
                'payment_id'    => 'Payment ID',
                'ref'           => 'Reference ID',
                'result'        => 'Result',
                'track_id'      => 'Track ID',
                'tran_id'       => 'Transaction ID',
            ],
            'transactions'  => 'Transaction',
        ],
    ],
    'transactions'  => [
        'datatable' => [
            'auth'          => 'Auth',
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'method'        => 'method',
            'options'       => 'Options',
            'payment_id'    => 'Payment ID',
            'post_date'     => 'Post Date',
            'ref'           => 'Reference',
            'result'        => 'Result',
            'track_id'      => 'Track ID',
            'tran_id'       => 'Transaction ID',
            'type'          => 'Transaction Type',
        ],
        'index'     => [
            'title' => 'Transactions',
        ],
    ],
];
