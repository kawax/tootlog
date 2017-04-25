<?php

namespace App\Repository\Status;

use App\Model\Account;
use App\Model\Status;
use App\Model\User;
use Cake\Chronos\Chronos;

class EloquentStatusRepository implements StatusRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function userStatuses()
    {
        $statuses = request()->user()
                             ->statuses()
                             ->with(['account', 'reblog'])
                             ->latest('created_at')
                             ->paginate(10);

        return $statuses;
    }

    /**
     * @inheritDoc
     */
    public function openUserStatuses(User $user)
    {
        $statuses = $user->statuses()
                         ->where('accounts.locked', false)
                         ->with(['account', 'reblog'])
                         ->latest('created_at')
                         ->paginate(10);

        return $statuses;
    }

    /**
     * @inheritDoc
     */
    public function openAcctStatuses(Account $acct)
    {
        if ($acct->locked) {
            abort(404);
        }

        $statuses = $acct->statuses()
                         ->with(['account', 'reblog'])
                         ->latest('created_at')
                         ->paginate(10);

        return $statuses;
    }

    /**
     * @inheritDoc
     */
    public function updateOrCreate(array $attr, array $values)
    {
        $status = Status::updateOrCreate($attr, $values);

        return $status;
    }
}
