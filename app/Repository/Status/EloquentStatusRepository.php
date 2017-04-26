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
                             ->withTrashed()
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
        $statuses = $acct->statuses()
                         ->with(['account', 'reblog'])
                         ->latest('created_at')
                         ->paginate(10);

        return $statuses;
    }

    /**
     * @inheritDoc
     */
    public function getByAcct(Account $acct, string $status_id)
    {
        $status = $acct->statuses()
                       ->withTrashed()
                       ->where('status_id', $status_id)
                       ->with(['account', 'reblog'])
                       ->firstOrFail();

        return $status;
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
