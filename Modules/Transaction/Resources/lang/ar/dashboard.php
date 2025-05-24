<?php

return [
    'orders'        => [
        'show'  => [
            'transaction'   => [
                'auth'          => 'AUTH',
                'method'        => 'طريقة الدفع',
                'payment_id'    => 'Payment ID',
                'ref'           => 'Reference ID',
                'result'        => 'نتيجة العملية',
                'track_id'      => 'Track ID',
                'tran_id'       => 'Transaction ID',
            ],
            'transactions'  => 'عملية الدفع',
        ],
    ],
    'transactions'  => [
        'datatable' => [
            'auth'          => 'Auth',
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'method'        => 'طريقة الدفع',
            'options'       => 'الخيارات',
            'payment_id'    => 'Payment ID',
            'post_date'     => 'Post Date',
            'ref'           => 'Reference',
            'result'        => 'النتيجة',
            'track_id'      => 'Track ID',
            'tran_id'       => 'Transaction ID',
            'type'          => 'نوع العملية',
        ],
        'index'     => [
            'title' => 'عمليات الدفع',
        ],
    ],
];
