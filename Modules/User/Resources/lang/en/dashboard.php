<?php

return [
    'admins' => [
        'create' => [
            'form' => [
                'confirm_password' => 'Confirm Password',
                'email' => 'Email',
                'general' => 'General Info.',
                'image' => 'Profile Image',
                'info' => 'Info.',
                'mobile' => 'Mobile',
                'name' => 'Name',
                'password' => 'Password',
                'roles' => 'Roles',
            ],
            'title' => 'Create Employees',
        ],
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'email' => 'Email',
            'image' => 'Image',
            'mobile' => 'Mobile',
            'name' => 'Name',
            'roles' => 'Roles',
            'options' => 'Options',
        ],
        'index' => [
            'title' => 'Employees',
        ],
        'update' => [
            'form' => [
                'confirm_password' => 'Confirm Password',
                'email' => 'Email',
                'general' => 'General info.',
                'image' => 'Profile Image',
                'mobile' => 'Mobile',
                'name' => 'Name',
                'password' => 'Change Password',
                'roles' => 'Roles',
            ],
            'title' => 'Update Employees',
        ],
        'validation' => [
            'email' => [
                'required' => 'Please enter the email of admin',
                'unique' => 'This email is taken before',
            ],
            'mobile' => [
                'digits_between' => 'Please add mobile number only 8 digits',
                'numeric' => 'Please enter the mobile only numbers',
                'required' => 'Please enter the mobile of admin',
                'unique' => 'This mobile is taken before',
            ],
            'name' => [
                'required' => 'Please enter the name of admin',
            ],
            'password' => [
                'min' => 'Password must be more than 6 characters',
                'required' => 'Please enter the password of admin',
                'same' => 'The Password confirmation not matching',
            ],
            'roles' => [
                'required' => 'Please select the role of admin',
            ],
        ],
    ],
    'drivers' => [
        'create' => [
            'form' => [
                'confirm_password' => 'Confirm Password',
                'email' => 'Email',
                'general' => 'General Info.',
                'image' => 'Profile Image',
                'info' => 'Info.',
                'mobile' => 'Mobile',
                'name' => 'Name',
                'password' => 'Password',
                'roles' => 'Roles',
                'company' => 'Company',
            ],
            'title' => 'Create Drivers',
        ],
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'email' => 'Email',
            'image' => 'Image',
            'mobile' => 'Mobile',
            'name' => 'Name',
            'options' => 'Options',
            'company' => 'Company',
        ],
        'index' => [
            'title' => 'Drivers',
        ],
        'update' => [
            'form' => [
                'confirm_password' => 'Confirm Password',
                'email' => 'Email',
                'general' => 'General info.',
                'image' => 'Profile Image',
                'mobile' => 'Mobile',
                'name' => 'Name',
                'password' => 'Change Password',
                'roles' => 'Roles',
            ],
            'title' => 'Update Drivers',
        ],
        'validation' => [
            'email' => [
                'required' => 'Please enter the email of driver',
                'unique' => 'This email is taken before',
            ],
            'mobile' => [
                'digits_between' => 'Please add mobile number only 8 digits',
                'numeric' => 'Please enter the mobile only numbers',
                'required' => 'Please enter the mobile of admin',
                'unique' => 'This mobile is taken before',
            ],
            'name' => [
                'required' => 'Please enter the name of admin',
            ],
            'password' => [
                'min' => 'Password must be more than 6 characters',
                'required' => 'Please enter the password of admin',
                'same' => 'The Password confirmation not matching',
            ],
            'roles' => [
                'required' => 'Please select the role of driver',
            ],
            'company_id' => [
                'required' => 'Please select the shipping company of driver',
            ],
        ],
        'tabs' => [
            'states' => 'Cities And States',
            'form' => [
                'state' => 'State',
                'status' => 'Status',
                'btn' => [
                    'activate_all' => 'Activate All',
                ],
            ],
        ],
    ],
    'sellers' => [
        'create' => [
            'form' => [
                'confirm_password' => 'Confirm Password',
                'email' => 'Email',
                'general' => 'General Info.',
                'image' => 'Profile Image',
                'info' => 'Info.',
                'mobile' => 'Mobile',
                'name' => 'Name',
                'password' => 'Password',
                'roles' => 'Roles',
            ],
            'title' => 'Create Sellers',
        ],
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'email' => 'Email',
            'image' => 'Image',
            'mobile' => 'Mobile',
            'name' => 'Name',
            'options' => 'Options',
        ],
        'index' => [
            'title' => 'Sellers',
        ],
        'update' => [
            'form' => [
                'confirm_password' => 'Confirm Password',
                'email' => 'Email',
                'general' => 'General info.',
                'image' => 'Profile Image',
                'mobile' => 'Mobile',
                'name' => 'Name',
                'password' => 'Change Password',
                'roles' => 'Roles',
            ],
            'title' => 'Update Seller',
        ],
        'validation' => [
            'email' => [
                'required' => 'please enter the email of seller',
                'unique' => 'This email is taken before',
            ],
            'mobile' => [
                'digits_between' => 'Please add mobile number only 8 digits',
                'numeric' => 'Please enter the mobile only numbers',
                'required' => 'Please enter the mobile of seller',
                'unique' => 'This mobile is taken before',
            ],
            'name' => [
                'required' => 'Please enter the name of seller',
            ],
            'password' => [
                'min' => 'Password must be more than 6 characters',
                'required' => 'Please enter the password of seller',
                'same' => 'The Password confirmation not matching',
            ],
            'roles' => [
                'required' => 'Please select the role of seller',
            ],
        ],
    ],
    'users' => [
        'create' => [
            'form' => [
                'confirm_password' => 'Confirm Password',
                'email' => 'Email',
                'general' => 'General Info.',
                'image' => 'Profile Image',
                'info' => 'Info.',
                'mobile' => 'Mobile',
                'name' => 'Name',
                'password' => 'Password',
                "is_verified" => "Is Verified",
                "addresses"       => "Addresses",
                "address_details"       => [
                    'country' => 'Country',
                    'city' => 'City',
                    'state' => 'Area',
                    'username' => 'Name',
                    'email' => 'Email',
                    'mobile' => 'Mobile',
                    'block' => 'Block',
                    'building' => 'Building',
                    'street' => 'Street',
                    'address' => 'Address Details',
                    'avenue' => 'Avenue',
                    'floor' => 'Floor',
                    'flat' => 'Flat',
                    'automated_number' => 'Automated Number',
                    'titles' => [
                        'create' => 'Create New Address',
                        'edit' => 'Edit Address',
                    ],
                ],
            ],
            'title' => 'Create Clients',
        ],
        "show"  => [
            "title" => "Client Info"
        ],
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'email' => 'Email',
            'image' => 'Image',
            'mobile' => 'Mobile',
            'name' => 'Name',
            "is_verified" => "Is Verified",
            'options' => 'Options',
            'address' => [
                'state' => 'Area',
                'username' => 'Name',
                'email' => 'Email',
                'mobile' => 'Mobile',
                'block' => 'Block',
                'building' => 'Building',
            ],
            'orders_count' => 'Orders Count',
        ],
        'index' => [
            'title' => 'Clients',
        ],
        'update' => [
            'form' => [
                'confirm_password' => 'Confirm Password',
                'email' => 'Email',
                'general' => 'General info.',
                'image' => 'Profile Image',
                'mobile' => 'Mobile',
                'name' => 'Name',
                'password' => 'Change Password',
                "is_verified" => "Is Verified",
            ],
            'title' => 'Update User',
        ],
        'validation' => [
            'email' => [
                'required' => 'Please enter the email of user',
                'unique' => 'This email is taken before',
            ],
            'mobile' => [
                'digits_between' => 'Please add mobile number only 8 digits',
                'numeric' => 'Please enter the mobile only numbers',
                'required' => 'Please enter the mobile of user',
                'unique' => 'This mobile is taken before',
            ],
            'name' => [
                'required' => 'Please enter the name of user',
            ],
            'password' => [
                'min' => 'Password must be more than 6 characters',
                'required' => 'Please enter the password of user',
                'same' => 'The Password confirmation not matching',
            ],
        ],
        'is_verified' => 'Is Verified',
    ],
];
