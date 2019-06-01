<?php

namespace App\Repository\Status\Traits;

use App\Model\Account;
use App\Model\User;
use App\Model\Tag;

trait Open
{
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
            $statuses = $statuses->where('content', 'like', '%'.request('search').'%');
        }

        $statuses = $statuses->paginate(self::PAGINATE);

        return $statuses;
    }

    /**
     * @inheritDoc
     */
    public function openUserStatusesByDate(User $user, string $year, ?string $month = null, ?string $day = null)
    {
        $query = $user->statuses()
                      ->where('accounts.locked', false)
                      ->whereYear('statuses.created_at', $year);

        if (! empty($month)) {
            $query = $query->whereMonth('statuses.created_at', $month);
        }

        if (! empty($day)) {
            $query = $query->whereDay('statuses.created_at', $day);
        }

        return $query->with(['account', 'reblog'])
                     ->latest('created_at')
                     ->paginate(self::PAGINATE);
    }

    /**
     * @inheritDoc
     */
    public function openRecents(User $user)
    {
        return cache()->remember('recents/'.$user->id, now()->addMinutes(60), function () use ($user) {
            return $user->statuses()
                        ->where('accounts.locked', false)
                        ->latest()
                        ->get()
                        ->groupBy(function ($item) {
                            return $item->created_at->format('Y-m-d');
                        })
                        ->take(10);
        });
    }

    /**
     * @inheritDoc
     */
    public function openArchives(User $user)
    {
        return cache()->remember('archives/'.$user->id, now()->addMinutes(60), function () use ($user) {
            return $user->statuses()
                        ->where('accounts.locked', false)
                        ->latest()
                        ->get()
                        ->groupBy(function ($item) {
                            return $item->created_at->format('Y-m');
                        });
        });
    }

    /**
     * @inheritDoc
     */
    public function openUserTagStatus(User $user, Tag $tag)
    {
        $accounts = $user->accounts()->where('locked', false)->pluck('id');

        $statuses = $tag->statuses()
                        ->whereIn('statuses.account_id', $accounts)
                        ->with(['account', 'reblog'])
                        ->latest();

        if (request()->has('search')) {
            $statuses = $statuses->where('content', 'like', '%'.request('search').'%');
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
            $statuses = $statuses->where('content', 'like', '%'.request('search').'%');
        }

        $statuses = $statuses->paginate(self::PAGINATE);

        return $statuses;
    }

    /**
     * @inheritDoc
     */
    public function openCalendar(User $user)
    {
        $from_date = now()->startOfYear()->format('Y-m-d');

        $statuses = $user->statuses()
                         ->whereDate('statuses.created_at', '>=', $from_date)
                         ->where('accounts.locked', false)
                         ->latest()
                         ->get()
                         ->groupBy(function ($item) {
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
        $from_date = now()->startOfYear()->format('Y-m-d');

        $statuses = $account->statuses()
                            ->whereDate('statuses.created_at', '>=', $from_date)
                            ->latest()
                            ->get()
                            ->groupBy(function ($item) {
                                return $item->created_at->format('Y-m-d');
                            });

        $cal = collect([]);

        foreach ($statuses as $key => $status) {
            $cal->prepend($status->count(), $key);
        }

        return $cal;
    }
}
