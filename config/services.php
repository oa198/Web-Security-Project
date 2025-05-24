<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID', 'Ov23liNKBwk1eX1AS1ex'),
        'client_secret' => env('GITHUB_CLIENT_SECRET', 'c53d14e57a94d2891dcf0855c5cef4b5b80428d4'),
        'redirect' => env('GITHUB_REDIRECT_URI', 'http://project.localhost.com/auth/github/callback'),
    ],
    
    'linkedin' => [
        'client_id' => env('LINKEDIN_CLIENT_ID', '864hsbfdunsfkx'),
        'client_secret' => env('LINKEDIN_CLIENT_SECRET', 'WPL_AP1.yqck66Um4NbvkrJr.POcssw=='),
        'redirect' => env('LINKEDIN_REDIRECT_URI', 'http://localhost:8000/auth/linkedin/callback'),
    ],
    
    'turnstile' => [
        'site_key' => env('TURNSTILE_SITE_KEY', '0x4AAAAAABPbY4booday-3at'),
        'secret_key' => env('CF_TURNSTILE_SECRET', '0x4AAAAAABPbY9XvgbVNAs-3Uv-7u4ll-Qo'),
    ],

];
