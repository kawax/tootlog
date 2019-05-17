<?php

namespace App\Repository\Status;

use App\Model\Account;
use App\Model\Status;

class EloquentStatusRepository implements StatusRepositoryInterface
{
    use Traits\Open;

    protected const PAGINATE = 20;

    /**
     * @inheritDoc
     */
    public function userStatuses()
    {
        $statuses = request()->user()
                             ->statuses()
                             ->withTrashed()
                             ->with('account', 'reblog')
                             ->latest('created_at');

        if (request()->has('search')) {
            $statuses = $statuses->where('content', 'like', '%'.request('search').'%');
        }

        $statuses = $statuses->paginate(self::PAGINATE);

        return $statuses;
    }

    /**
     * @inheritDoc
     */
    public function getByAcct(Account $acct, string $status_id)
    {
        $key = 'account/'.$acct->id.'/status/'.$status_id;

        $status = cache()->remember($key, now()->addDay(), function () use ($acct, $status_id) {
            return $acct->statuses()
                        ->withTrashed()
                        ->where('status_id', $status_id)
                        ->with(['account', 'reblog'])
                        ->firstOrFail();
        });

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

    /**
     * @inheritDoc
     */
    public function exportCsv(Account $account)
    {
        return $account->statuses()
                       ->withTrashed()
                       ->where('reblog_id', null)
                       ->with('account')
                       ->latest();
    }
}
