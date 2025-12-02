<?php

return [
    'version' => 'v1.20.0',

    // 一度に更新するアカウント数
    'account_limit' => 10,

    // 連続して失敗したらサーバーが死んでる判定。
    'account_fails' => 10,

    // streaming api用のURLが違う場合
    'streaming' => [],

    'favicon_size' => 24,

    // faviconが違う場合
    'favicon' => [
        'https://pawoo.net' => 'favicon.png',
    ],
];
