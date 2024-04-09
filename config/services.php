<?php

use function Revolution\Illuminate\Support\env;

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
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'mastodon' => [
        'domain' => env('MASTODON_DOMAIN', 'https://chitose.moe'),
        'client_id' => env('MASTODON_ID'),
        'client_secret' => env('MASTODON_SECRET'),
        'redirect' => env('MASTODON_REDIRECT'),
        //'read', 'write', 'follow'
        'scope' => ['read'],
    ],

    'mastodon_notify' => [
        'domain' => env('MASTODON_NOTIFY_DOMAIN', 'https://chitose.moe'),
        'token' => env('MASTODON_NOTIFY_TOKEN'),
    ],
];
