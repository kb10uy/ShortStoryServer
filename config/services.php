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
    
    //Socialite
    'twitter' => [
        'client_id' => env('TWITTER_CK'),
        'client_secret' => env('TWITTER_CS'),
        'redirect' => 'https://ss.kb10uy.org/login/twitter/callback',
    ],
    
    'github' => [
        'client_id' => env('GITHUB_CK'),
        'client_secret' => env('GITHUB_CS'),
        'redirect' => 'https://ss.kb10uy.org/login/github/callback',
    ],
];
