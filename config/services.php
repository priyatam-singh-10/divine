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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'whatsapp' => [
        'url' => env('WHATSAPP_API_URL'),
        'message_type' => env('WHATSAPP_MESSAGE_TYPE', 'text'),
        'token' => env('WHATSAPP_TOKEN'),
        'from' => env('WHATSAPP_FROM'),
        'request_type' => env('WHATSAPP_REQUEST_TYPE', 'POST'),
        'zoom_link' => env('WHATSAPP_ZOOM_LINK', 'https://us06web.zoom.us/j/89645866205?pwd=nUMMfKCa6LKKnkLPpavRQC38TuaOaq.1'),
        'image_url' => env('WHATSAPP_IMAGE_URL', 'https://www.divinetouch.info/public/assets/whatsapp/A.png'),
        'image_base_url' => env('WHATSAPP_IMAGE_BASE_URL', 'https://www.divinetouch.info/public/assets/whatsapp'),
        'community_link' => env('WHATSAPP_COMMUNITY_LINK', 'https://chat.whatsapp.com/J6ofB4AWVOUKNQEKzaf7si'),
    ],

    'ai_wealth_sheet' => [
        'id' => env('AI_WEALTH_GOOGLE_SHEET_ID', '1wAeg1Y4WMnNThQBHw-RUU_nGvmpPcAdhQPTSBYTqR0s'),
        'gid' => env('AI_WEALTH_GOOGLE_SHEET_GID', '0'),
    ],

];
