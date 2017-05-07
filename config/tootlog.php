<?php
return [
    'version'       => 'v0.5.3-beta',

    //一度に更新するアカウント数
    'account_limit' => 3,

    //連続して失敗したらサーバーが死んでる判定。
    'account_fails' => 10,

    //streaming api用のURLが違う場合
    'streaming'     => [
        'https://chitose.moe' => 'https://api.chitose.moe',
        'https://mstdn.jp'    => 'https://streaming.mstdn.jp',
    ],
];
