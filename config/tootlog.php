<?php
return [
    'version'       => 'v0.0.2-alpha',

    //一度に更新するアカウント数
    'account_limit' => 3,

    //連続して失敗したらサーバーが死んでる判定。
    'account_fails' => 10,
];
