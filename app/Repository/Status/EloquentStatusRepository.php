<?php

namespace App\Repository\Status;

use App\Models\Account;
use App\Models\Status;

class EloquentStatusRepository implements StatusRepository
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

        return $statuses->paginate(self::PAGINATE);
    }

    /**
     * {@inheritdoc}
     */
    public function getByAcct(Account $acct, int $status_id)
    {
        $key = 'account/'.$acct->id.'/status/'.$status_id;

        return cache()->remember($key, now()->addDay(), function () use ($acct, $status_id) {
            return $acct->statuses()
                        ->withTrashed()
                        ->where('status_id', $status_id)
                        ->with(['account', 'reblog'])
                        ->firstOrFail();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function updateOrCreate(array $attr, array $values)
    {
        return Status::withTrashed()->updateOrCreate($attr, $values);
    }

    /**
     * {@inheritdoc}
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
