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

    /*
    | MoMo (Ví điện tử) — mặc định dùng bộ thông tin SANDBOX CÔNG KHAI của MoMo
    | (lấy từ tài liệu dev MoMo, dùng cho test, KHÔNG phải tiền thật).
    | Khi lên production: đăng ký merchant tại business.momo.vn rồi đặt
    | MOMO_PARTNER_CODE / MOMO_ACCESS_KEY / MOMO_SECRET_KEY trong .env.
    */
    /*
    | Base URL cho ẢNH trong EMAIL. Vì email mở trên thiết bị khác (điện thoại),
    | không thể dùng http://127.0.0.1 (localhost của máy chủ). Mặc định trỏ tới
    | ảnh public trên GitHub repo (đã commit) để mở được ở mọi nơi.
    | Production: đặt MAIL_ASSET_URL = domain thật của shop.
    */
    'mail_asset_url' => env('MAIL_ASSET_URL', 'https://raw.githubusercontent.com/chunpapogreyrat/skt-gaming-store/master/public'),

    'momo' => [
        'partner_code' => env('MOMO_PARTNER_CODE', 'MOMO'),
        'access_key' => env('MOMO_ACCESS_KEY', 'F8BBA842ECF85'),
        'secret_key' => env('MOMO_SECRET_KEY', 'K951B6PE1waDMi640xX08PD3vg6EkVlz'),
        'endpoint' => env('MOMO_ENDPOINT', 'https://test-payment.momo.vn/v2/gateway/api/create'),
        'query_endpoint' => env('MOMO_QUERY_ENDPOINT', 'https://test-payment.momo.vn/v2/gateway/api/query'),
    ],

];
