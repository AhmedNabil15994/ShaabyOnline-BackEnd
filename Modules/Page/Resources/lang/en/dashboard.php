<?php

return [
    'pages' => [
      'form'  => [
          'description'       => 'Description',
          'meta_description'  => 'Meta Description',
          'meta_keywords'     => 'Meta Keywords',
          'status'            => 'Status',
          'title'             => 'Title',
          'type'              => 'In footer',
          'tabs'  => [
            'general'           => 'General Info.',
            'seo'               => 'SEO',
          ]
      ],
      'datatable' => [
          'created_at'    => 'Created At',
          'date_range'    => 'Search By Dates',
          'options'       => 'Options',
          'status'        => 'Status',
          'title'         => 'Title',
      ],
      'routes'     => [
          'create' => 'Create Pages',
          'index' => 'Pages',
          'update' => 'Update Page',
      ],
      'validation'=> [
          'description'   => [
              'required'  => 'Please enter the description of page',
          ],
          'title'         => [
              'required'  => 'Please enter the title of page',
              'unique'    => 'This title page is taken before',
          ],
      ],
    ],
];
