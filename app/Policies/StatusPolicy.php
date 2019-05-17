<?php

namespace App\Policies;

use App\Model\User;
use App\Model\Status;

use Illuminate\Auth\Access\HandlesAuthorization;

class StatusPolicy
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
     * @param  User  $user
     * @param  Status  $status
     *
     * @return bool
     */
    public function hide(User $user, Status $status)
    {
        return (int) $user->id === (int) $status->account->user_id;
    }
}
