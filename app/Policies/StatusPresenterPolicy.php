<?php

namespace App\Policies;

use App\Model\User;
use App\Model\Status;
use App\Presenter\StatusPresenter;

use Illuminate\Auth\Access\HandlesAuthorization;

class StatusPresenterPolicy
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
     * @param User            $user
     * @param StatusPresenter $status
     *
     * @return bool
     */
    public function hide(User $user, StatusPresenter $status)
    {
        return (int)$user->id === (int)$status->getWrappedObject()->account->user_id;
    }
}
