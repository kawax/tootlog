<?php

namespace App\Repository\Account;

use App\Models\Account;
use App\Models\User;

interface AccountRepository
{
    /**
     * @return mixed
     */
    public function all();

    /**
     * @return mixed
     */
    public function find($id);

    /**
     * toot:statusesのためのアカウントリスト.
     *
     * @return array
     */
    public function oldest();

    /**
     * toot:statusesのためのアカウントリスト。特典キーが有効な場合。
     *
     * @return array
     */
    public function special();

    /**
     * ユーザーのアカウント.
     *
     * @return array
     */
    public function userAccounts();

    /**
     * ユーザーのアカウント（公開用）.
     *
     * @param  User  $user
     * @return array
     */
    public function openAccounts(User $user);

    /**
     * ユーザー名とドメインからアカウント.
     *
     * @param  string  $username
     * @param  string  $domain
     * @return Account
     */
    public function getByAcct(string $username, string $domain);

    /**
     * アカウント情報を更新.
     *
     * @param  Account  $account
     * @return mixed
     */
    public function refresh(Account $account);

    /**
     * since_idを更新.
     *
     * @param  Account  $account
     * @return mixed
     */
    public function updateSince(Account $account, $since_id);

    /**
     * @param  $user
     * @param  array  $server
     * @return mixed
     */
    public function store($user, array $server);

    /**
     * @param $user
     * @return mixed
     */
    public function update($user);

    /**
     * @param  string  $url
     * @return bool
     */
    public function exists(string $url): bool;

    /**
     * @param  int  $id
     */
    public function destroy(int $id): void;
}
