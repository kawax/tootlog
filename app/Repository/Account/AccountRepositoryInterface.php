<?php

namespace App\Repository\Account;

use App\Model\User;
use App\Model\Account;

interface AccountRepositoryInterface
{

    /**
     *
     * @return mixed
     */
    public function all();

    /**
     *
     * @return mixed
     */
    public function find($id);

    /**
     * toot:statusesのためのアカウントリスト
     *
     * @return Account[]
     */
    public function oldest();

    /**
     * ユーザーのアカウント
     *
     * @return Account[]
     */
    public function userAccounts();

    /**
     * ユーザーのアカウント（公開用）
     *
     * @param User $user
     *
     * @return Account[]
     */
    public function openAccounts(User $user);

    /**
     * ユーザー名とドメインからアカウント
     *
     * @param string $username
     * @param string $domain
     *
     * @return Account
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
     * @param array $server
     *
     * @return mixed
     */
    public function store($user, array $server);

    /**
     * @param $user
     *
     * @return mixed
     */
    public function update($user);

    /**
     * @param string $url
     *
     * @return bool
     */
    public function exists(string $url): bool;

}
