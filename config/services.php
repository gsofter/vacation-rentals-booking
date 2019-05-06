<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT')
        ],
        'facebook' => [ 
        'client_id'     => env ('FB_CLIENT_ID'),
        'client_secret' => env ('FB_CLIENT_SECRET'),
        'redirect'      => env ('FB_REDIRECT') 
        ],
    'braintree' => [
        'model'  => App\User::class,
        'environment' => env('BRAINTREE_ENV'),
        'merchant_id' => env('BRAINTREE_MERCHANT_ID'),
        'public_key' => env('BRAINTREE_PUBLIC_KEY'),
        'private_key' => env('BRAINTREE_PRIVATE_KEY'),
    ],
    'linkedin' => [
        'client_id' => env ('LINKEDIN_CLIENT_ID'),
        'client_secret' => env ('LINKEDIN_CLIENT_SECRET'),
        'redirect' =>env ('LINKEDIN_REDIRECT')],
    'twilio' => [
        'default' => 'twilio',
        'connections' => [
            'twilio' => [
               
                'sid' => env('TWILIO_SID') ?: 'ACf143f38d0f91d7f0ab730948d36e461d',
               
                'token' => env('TWILIO_TOKEN') ?: 'a2a4e9070d5cef1c3c7cf61b03efb10e',
                
                'from' => env('TWILIO_FROM') ?: '+14172970597',
            ],
        ],
    ],
];
