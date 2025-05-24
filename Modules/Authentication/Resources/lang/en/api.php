<?php

return [
    'forget_password' => [
        'mail' => [
            'subject' => 'Reset Password',
        ],
        'messages' => [
            'success' => 'Reset Password Send Successfully',
            'user_not_exist' => 'This user not exists',
            'user_exist' => 'This user is in our records',
        ],
        'validation' => [
            'email' => [
                'email' => 'Please enter correct email format',
                'required' => 'The email field is required',
            ],
            'mobile' => [
                'digits_between' => 'You must enter mobile number with 8 digits',
                'numeric' => 'The mobile must be a number',
                'required' => 'The mobile field is required',
                'unique' => 'The mobile has already been taken',
                'exists' => 'The mobile not exists',
            ],
            'calling_code' => [
                'required' => 'The calling code field is required',
                'numeric' => 'The calling code must be a number',
                'max' => 'You must enter calling code with 3 digits',
            ],
            'firebase_id' => [
                'required' => 'The firebase id field is required',
                'exists' => 'The firebase id not exists',
            ],
            'code' => [
                'required' => 'Please enter verification code',
            ],
        ],
    ],
    'login' => [
        'validation' => [
            'email' => [
                'email' => 'Please enter correct email format',
                'required' => 'The email field is required',
            ],
            'failed' => 'These credentials do not match our records.',
            'password' => [
                'min' => 'Password must be more than 6 characters',
                'required' => 'The password field is required',
            ],
            "code_verified" => [
                "not_correct" => "code verified is not correct"
            ],
        ],
    ],
    'logout' => [
        'messages' => [
            'failed' => 'logout failed',
            'success' => 'logout successfully',
        ],
    ],
    "resend" => [
        "success" => "successfully send code"
    ],
    'password' => [
        'messages' => [
            'sent' => 'Reset password sent successfully',
        ],
        'validation' => [
            'email' => [
                'email' => 'Please enter correct email format',
                'exists' => 'This email not exists',
                'required' => 'The email field is required',
            ],
        ],
    ],
    'register' => [
        'messages' => [
            'failed' => 'Register Failed , Please try again later',
            "error_sms" => "ُError in sms messages sender",
            "code_send" => "Your verification code is : :code ",
            "code" => "verification code not correct",
        ],
        'validation' => [
            'email' => [
                'email' => 'Please enter correct email format',
                'required' => 'The email field is required',
                'unique' => 'The email has already been taken',
            ],
            'mobile' => [
                'digits_between' => 'You must enter mobile number with 8 digits',
                'numeric' => 'The mobile must be a number',
                'required' => 'The mobile field is required',
                'unique' => 'The mobile has already been taken',
            ],
            'name' => [
                'required' => 'The name field is required',
            ],
            'password' => [
                'confirmed' => 'Password not match with the cnofirmation',
                'min' => 'Password must be more than 6 characters',
                'required' => 'The password field is required',
            ],
            'calling_code' => [
                'required' => 'The calling code field is required',
                'numeric' => 'The calling code must be a number',
                'max' => 'You must enter calling code with 3 digits',
            ],
            'email_or_mobile' => [
                'required' => 'The email or mobile field is required',
            ],
            'firebase_id' => [
                'required' => 'The firebase id field is required',
                'exists' => 'The firebase id not exists',
                'unique' => 'The firebase id has already been taken',
            ],
        ],
    ],
    'reset' => [
        'mail' => [
            'button_content' => 'Reset Your Password',
            'header' => 'You are receiving this email because we received a password reset request for your account.',
            'subject' => 'Reset Password',
        ],
        'title' => 'Reset Password',
        'validation' => [
            'email' => [
                'email' => 'Please enter correct email format',
                'exists' => 'This email not exists',
                'required' => 'The email field is required',
            ],
            'password' => [
                'min' => 'Password must be more than 6 characters',
                'required' => 'The password field is required',
            ],
            'token' => [
                'exists' => 'This token expired',
                'required' => 'The token field is required',
            ],
        ],
    ],
];
