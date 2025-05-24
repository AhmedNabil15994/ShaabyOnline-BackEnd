<?php

return [
  'cities' => [
    'form'  => [
        'countries' => 'Select Country',
        'status'    => 'Status',
        'title'     => 'Title',
        'tabs'  => [
          'general'   => 'General Info.',
        ]
    ],
    'datatable' => [
        'countries' => 'Country',
        'created_at'=> 'Created At',
        'options'   => 'Options',
        'status'    => 'Status',
        'title'     => 'Title',
    ],
    'routes'     => [
        'create' => 'Create Citites',
        'index' => 'Cities',
        'update' => 'Update City',
    ],
    'validation'=> [
        'country_id'    => [
            'required'  => 'Please select country of this city',
        ],
        'title'         => [
            'required'  => 'Please add the title of city',
            'unique'    => 'This title is taken before',
        ],
    ],
  ],
  'countries' => [
    'form'  => [
        'status'    => 'Status',
        'title'     => 'Title',
        'code'      => 'Code',
        'tabs'  => [
          'general'   => 'General Info.',
        ]
    ],
    'datatable' => [
        'created_at'    => 'Created at',
        'options'       => 'Options',
        'status'        => 'Status',
        'title'         => 'Title',
        'code'      => 'Code',
    ],
    'routes'     => [
        'create' => 'Create Country',
        'index'  => 'Countires',
        'update' => 'Update Country',
    ],
    'validation'=> [
        'title' => [
            'required'  => 'Please add title for this country',
            'unique'    => 'This title is taken before',
        ],
        'code' => [
            'required'  => 'Please add code for this country',
            'unique'    => 'This code is taken before',
            'string'    => 'The code must consist of capital letters only',
        ],
    ],
  ],
  'states' => [
    'form'  => [
        'cities'    => 'Select City',
        'status'    => 'Status',
        'title'     => 'Title',
        'tabs'  => [
          'general'   => 'General Info.',
        ]
    ],
    'datatable' => [
        'cities'        => 'City',
        'created_at'    => 'Created at',
        'options'       => 'Options',
        'status'        => 'Status',
        'title'         => 'Title',
    ],
    'routes'     => [
        'create' => 'Create States',
        'index' => 'States',
        'update' => 'Update State',

    ],
    'validation'=> [
        'city_id'   => [
            'required'  => 'Please Select city of this state',
        ],
        'title'     => [
            'required'  => 'Please add the title',
            'unique'    => 'This title is taken before',
        ],
    ],
  ],
];
