<?php

return [
    'pages' => [
        'form'  => [
            'description'       => 'الوصف',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'status'            => 'الحالة',
            'title'             => 'عنوان الصفحة',
            'type'              => 'في تذيل الصفحة',
            'tabs'  => [
              'general'   => 'بيانات عامة',
              'seo'               => 'SEO',
            ],
        ],
        'routes'    => [
          'create'  => 'اضافة الصفحات',
          'index'   => 'الصفحات',
          'update'  => 'تعديل الصفحة',
        ],
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'validation'=> [
            'description'   => [
                'required'  => 'من فضلك ادخل وصف الصفحة',
            ],
            'title'         => [
                'required'  => 'من فضلك ادخل عنوان الصفحة',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
];
