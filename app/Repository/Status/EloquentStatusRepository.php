<?php

namespace App\Repository\Status;

use App\Model\Account;
use App\Model\Status;
use App\Model\User;
use App\Model\Tag;

use Cake\Chronos\Chronos;

class EloquentStatusRepository implements StatusRepositoryInterface
{
    const PAGINATE = 20;

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
            $statuses = $statuses->where('content', 'like', '%' . request('search') . '%');
        }

        $statuses = $statuses->paginate(self::PAGINATE);

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
                         ->latest('created_at');

        if (request()->has('search')) {
            $statuses = $statuses->where('content', 'like', '%' . request('search') . '%');
        }

        $statuses = $statuses->paginate(self::PAGINATE);

        return $statuses;
    }

    /**
     * @inheritDoc
     */
    public function openUserStatusesByDate(User $user, string $date)
    {
        $statuses = $user->statuses()
                         ->where('accounts.locked', false)
                         ->whereDate('statuses.created_at', $date)
                         ->with(['account', 'reblog'])
                         ->latest('created_at')
                         ->paginate(self::PAGINATE);

        return $statuses;
    }

    /**
     * @inheritDoc
     */
    public function openRecents(User $user)
    {
        $recents = $user->statuses()
                        ->where('accounts.locked', false)
                        ->latest()
                        ->get()
                        ->groupBy(function ($item, $key) {
                            return $item->created_at->format('Y-m-d');
                        })
                        ->take(10);

        return $recents;
    }

    /**
     * @inheritDoc
     */
    public function openUserTagStatus(User $user, Tag $tag)
    {
        $accounts = $user->accounts()->where('locked', false)->pluck('id');

        $statuses = $tag->statuses()
                        ->whereIn('statuses.account_id', $accounts)
                        ->latest();

        if (request()->has('search')) {
            $statuses = $statuses->where('content', 'like', '%' . request('search') . '%');
        }

        $statuses = $statuses->paginate(self::PAGINATE);

        return $statuses;
    }

    /**
     * @inheritDoc
     */
    public function openAcctStatuses(Account $acct)
    {
        $statuses = $acct->statuses()
                         ->with(['account', 'reblog'])
                         ->latest('created_at');

        if (request()->has('search')) {
            $statuses = $statuses->where('content', 'like', '%' . request('search') . '%');
        }

        $statuses = $statuses->paginate(self::PAGINATE);

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
    public function openCalendar(User $user)
    {
        $from_date = Chronos::now()->startOfYear()->format('Y-m-d');

        $statuses = $user->statuses()
                         ->whereDate('statuses.created_at', '>=', $from_date)
                         ->where('accounts.locked', false)
                         ->latest()
                         ->get()
                         ->groupBy(function ($item, $key) {
                             return $item->created_at->format('Y-m-d');
                         });

        $cal = collect([]);

        foreach ($statuses as $key => $status) {
            $cal->prepend($status->count(), $key);
        }

        return $cal;
    }

    /**
     * @inheritDoc
     */
    public function openAcctCalendar(Account $account)
    {
        $from_date = Chronos::now()->startOfYear()->format('Y-m-d');

        $statuses = $account->statuses()
                            ->whereDate('statuses.created_at', '>=', $from_date)
                            ->latest()
                            ->get()
                            ->groupBy(function ($item, $key) {
                                return $item->created_at->format('Y-m-d');
                            });

        $cal = collect([]);

        foreach ($statuses as $key => $status) {
            $cal->prepend($status->count(), $key);
        }

        return $cal;
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
                       ->latest()
                       ->get();
    }
}
