<?php

return [
    'login' => [
        'form' => [
            'btn' => [
                'forget_password' => 'Forget Password ?',
                'login' => 'Login',
            ],
            'email' => 'E-mail address',
            'email_or_mobile' => 'E-mail address or mobile without country key',
            'password' => 'Password',
            'remember_me' => 'Remember Me',
            'not_have_account' => 'Don\'t have an account?',
            'have_account' => 'Have an account?',
            'sign_up_now' => 'Sign Up Now',
        ],
        'title' => 'Login',
        'login_or_signup' => 'Login Or Sign up',
        'login_welcome_msg' => 'Welcome, you can log in from here',
        'validation' => [
            'email' => [
                'email' => 'Please enter correct email format',
                'required' => 'The email field is required',
                'exists' => 'This user does not exist for us',
            ],
            'failed' => 'These credentials do not match our records.',
            'password' => [
                'min' => 'Password must be more than 6 characters',
                'required' => 'The password field is required',
            ],
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
    'register' => [
        'alert' => [
            'policy_privacy' => 'if you register it mean you are confirm',
        ],
        'btn' => [
            'policy_privacy' => 'Policy & Privacy',
            'register' => 'Register',
        ],
        'form' => [
            'email' => 'Email Address',
            'mobile' => 'Mobile',
            'name' => 'Name',
            'password' => 'Password',
            'password_confirmation' => 'Password Confirmation',
        ],
        'title' => 'Registration',
        'register_new_account' => 'Create New Account',
        'register_welcome_msg' => 'Welcome, you can create a new account from here',
        'terms_msg' => 'By registering you have agreed to',
        'terms_and_conditions' => 'Terms and Conditions',
        'validation' => [
            'email' => [
                'email' => 'Please enter correct email format',
                'required' => 'The email field is required',
                'unique' => 'The email has already been taken',
            ],
            'mobile' => [
                'digits_between' => 'You must enter mobile number with 8 digits',
                'digits' => 'You must enter mobile number with 8 digits',
                'numeric' => 'The mobile must be a number',
                'required' => 'The mobile field is required',
                'phone' => 'The mobile field is invalid',
                'unique' => 'The mobile has already been taken',
                'max' => 'The phone number must not exceed 9 digits',
            ],
            'name' => [
                'required' => 'The name field is required',
            ],
            'password' => [
                'confirmed' => 'Password not match with the confirmation',
                'min' => 'Password must be more than 6 characters',
                'required' => 'The password field is required',
            ],
            'email_or_mobile' => [
                'required' => 'The email or mobile field is required',
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
        'messages' => [
            'success_reset' => 'Password Reset Successfully',
        ],
    ],
    'verification_code' => [
        'title' => 'Verification Code',
        'enter_your_verification_code' => 'Please enter the verification code that was sent to you.',
        'mobile_code_is_not_confirmed' => 'The mobile number is inactive',
        'click_here_to_confirm' => 'Click here to activate',
        'form' => [
            'code' => 'Verification Code',
            'btn' => [
                'send' => 'Send',
            ],
        ],
        'validation' => [
            'verification_code' => [
                'required' => 'Please enter verification code',
                'exists' => 'Please enter verification code',
            ],
            'mobile' => [
                'exists' => 'Your mobile number is not registered',
            ],
        ],
        'messages' => [
            'your_verification_code_is' => 'Your verification code is:',
            'unable_to_send_verification_code' => 'We were unable to send an verification code to you, try again',
        ],
    ],
];
