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
     */
    public function __construct()
    {
        //
    }

    public function show(User $user, Account $account): bool
    {
        return (int) $user->id === (int) $account->user_id;
    }

    public function update(User $user, Account $account): bool
    {
        return (int) $user->id === (int) $account->user_id;
    }

    public function delete(User $user, Account $account): bool
    {
        return (int) $user->id === (int) $account->user_id;
    }
}
