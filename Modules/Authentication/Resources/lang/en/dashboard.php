<?php

return [
    'login' => [
        'form'          => [
            'btn'       => [
                'login' => 'Login Now',
            ],
            'email'     => 'ِEmail address',
            'password'  => 'Password',
            'password_confirmation'  => 'Password Confirmation',
            'forget_password'  => 'Forget Password ?',
        ],
        'routes'        => [
            'index' => 'Login',
        ],
        'validations'   => [
            'email'     => [
                'email'     => 'Please add correct email format',
                'required'  => 'Please add your email address',
            ],
            'failed'    => 'These credentials do not match our records.',
            'password'  => [
                'min'       => 'Password must be more than 6 characters',
                'required'  => 'The password field is required',
            ],
            'do_not_have_access' => 'Sorry, you do not have access',
        ],
    ],
    'password' => [
        'alert' => [
            'reset_sent' => 'Reset password sent successfully',
        ],
        'form' => [
            'btn' => [
                'password' => 'Send Reset Password',
            ],
            'email' => 'Email address',
        ],
        'title' => 'Forget Password',
        'validation' => [
            'email' => [
                'email' => 'Please enter correct email format',
                'exists' => 'This email not exists',
                'required' => 'The email field is required',
            ],
        ],
    ],
    'reset' => [
        'form' => [
            'btn' => [
                'reset' => 'Reset Password Now',
            ],
            'email' => 'Email Address',
            'password' => 'Password',
            'password_confirmation' => 'Password Confirmation',
        ],
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
