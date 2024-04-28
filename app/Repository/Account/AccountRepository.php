<?php

namespace App\Repository\Account;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface AccountRepository
{
    public function all(): Collection;

    public function find(int $id): Account;

    /**
     * toot:statusesのためのアカウントリスト.
     */
    public function oldest(): Collection;

    /**
     * toot:statusesのためのアカウントリスト。特典キーが有効な場合。
     */
    public function special(): Collection;

    /**
     * ユーザーのアカウント.
     */
    public function userAccounts(): Collection;

    /**
     * ユーザーのアカウント（公開用）.
     */
    public function openAccounts(User $user): Collection;

    /**
     * ユーザー名とドメインからアカウント.
     */
    public function getByAcct(string $username, string $domain): Account;

    /**
     * アカウント情報を更新.
     */
    public function refresh(Account $account): Account;

    /**
     * since_idを更新.
     */
    public function updateSince(Account $account, int $since_id): void;

    public function store(mixed $user, array $server): Account;

    public function update(mixed $user): Account;

    public function exists(string $url): bool;

    public function destroy(int $id): void;
}
