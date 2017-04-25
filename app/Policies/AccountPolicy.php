<?php

namespace App\Policies;

use App\Model\User;
use App\Model\Account;

use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * ユーザにより指定されたポストが更新可能か決める
     *
     * @param  User    $user
     * @param  Account $account
     *
     * @return bool
     */
    public function show(User $user, Account $account)
    {
        return $account->locked = false or $user->id === $account->user_id;
    }
}
