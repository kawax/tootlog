<?php

namespace App\Repository\Account;

use App\Model\Account;

interface AccountRepositoryInterface
{

    /**
     *
     * @return mixed
     */
    public function all();

    /**
     * toot:statusesのためのアカウントリスト
     *
     * @return mixed
     */
    public function oldest();

    /**
     * ユーザーのアカウント
     *
     * @return mixed
     */
    public function userAccounts();

    /**
     * ユーザーのアカウント（公開用）
     *
     * @return mixed
     */
    public function openAccounts($user);

    /**
     * ユーザー名とドメインからアカウント
     *
     * @param string $username
     * @param string $domain
     *
     * @return mixed
     */
    public function getByAcct(string $username, string $domain);

    /**
     * アカウント情報を更新
     *
     * @param Account $account
     *
     * @return mixed
     */
    public function refresh(Account $account);

    /**
     * since_idを更新
     *
     * @param Account $account
     *
     * @return mixed
     */
    public function updateSince(Account $account, $since_id);

    /**
     * @param $user
     * @param $server
     *
     * @return mixed
     */
    public function store($user, $server);

    /**
     * @param string $url
     *
     * @return bool
     */
    public function exists(string $url): bool;

}
