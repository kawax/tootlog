<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\User;
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
     * ユーザにより指定されたポストが更新可能か決める.
     *
     * @param  User  $user
     * @param  Account  $account
     *
     * @return bool
     */
    public function show(User $user, Account $account)
    {
        return (int) $user->id === (int) $account->user_id;
    }

    /**
     * @param  User  $user
     * @param  Account  $account
     *
     * @return bool
     */
    public function delete(User $user, Account $account)
    {
        return (int) $user->id === (int) $account->user_id;
    }
}
