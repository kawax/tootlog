<?php

use function Revolution\Illuminate\Support\env;

return [
    'version'       => 'v1.12.0',

    //一度に更新するアカウント数
    'account_limit' => 3,

    //連続して失敗したらサーバーが死んでる判定。
    'account_fails' => 10,

    //streaming api用のURLが違う場合
    'streaming'     => [
        'https://qiitadon.com' => 'wss://streaming.qiitadon.com:4000',
    ],

    'favicon_size' => 24,

    //faviconが違う場合
    'favicon'      => [
        'https://pawoo.net' => 'favicon.png',
    ],

    'analytics'             => env('GOOGLE_ANALYTICS'),

    //特典キー
    'special_key'           => env('SPECIAL_KEY', ''),

    //一度に更新するアカウント数。special版
    'account_limit_special' => 3,
];
