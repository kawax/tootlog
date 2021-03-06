<?php

namespace App\Repository\Status\Traits;

use App\Models\Account;
use App\Models\Tag;
use App\Models\User;

trait Open
{
    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function openUserStatusesByDate(User $user, string $year, ?string $month = null, ?string $day = null)
    {
        return $user->statuses()
                    ->where('accounts.locked', false)
                    ->whereYear('statuses.created_at', $year)
                    ->when(filled($month), fn ($query) => $query->whereMonth('statuses.created_at', $month))
                    ->when(filled($day), fn ($query) => $query->whereDay('statuses.created_at', $day))
                    ->with(['account', 'reblog'])
                    ->latest()
                    ->simplePaginate(self::PAGINATE);
    }

    /**
     * {@inheritdoc}
     */
    public function openRecents(User $user)
    {
        return cache()->remember('recents/'.$user->id, now()->addDay(), function () use ($user) {
            $date_format = app()->runningUnitTests()
                ? 'STRFTIME("%Y-%m-%d", statuses.created_at)'
                : 'DATE_FORMAT(statuses.created_at,"%Y-%m-%d")';

            return $user->statuses()
                        ->select(['statuses.id', 'statuses.created_at', 'statuses.account_id'])
                        ->selectRaw($date_format.' as date')
                        ->with(['account:id,locked'])
                        ->where('accounts.locked', false)
                        ->latest('date')
                        ->cursor()
                        ->groupBy('date')
                        ->take(10)
                        ->map(function ($item) {
                            return $item->count();
                        })
                        ->collect();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function openArchives(User $user)
    {
        return cache()->remember('archives/'.$user->id, now()->addDay(), function () use ($user) {
            $date_format = app()->runningUnitTests()
                ? 'STRFTIME("%Y-%m", statuses.created_at)'
                : 'DATE_FORMAT(statuses.created_at,"%Y-%m")';

            return $user->statuses()
                        ->select(['statuses.id', 'statuses.created_at', 'statuses.account_id'])
                        ->selectRaw($date_format.' as date')
                        ->with(['account:id,locked'])
                        ->where('accounts.locked', false)
                        ->latest('date')
                        ->cursor()
                        ->groupBy('date')
                        ->map(function ($item) {
                            return $item->count();
                        })
                        ->collect();
        });
    }

    /**
     * {@inheritdoc}
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

        $statuses = $statuses->simplePaginate(self::PAGINATE);

        return $statuses;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function openCalendar(User $user)
    {
        $from_date = now()->startOfYear()->format('Y-m-d');

        $statuses = $user->statuses()
                         ->whereDate('statuses.created_at', '>=', $from_date)
                         ->where('accounts.locked', false)
                         ->latest()
                         ->get()
                         ->groupBy(fn ($item) => $item->created_at->format('Y-m-d'));

        $cal = collect([]);

        foreach ($statuses as $key => $status) {
            $cal->prepend($status->count(), $key);
        }

        return $cal;
    }

    /**
     * {@inheritdoc}
     */
    public function openAcctCalendar(Account $account)
    {
        $from_date = now()->startOfYear()->format('Y-m-d');

        $statuses = $account->statuses()
                            ->whereDate('statuses.created_at', '>=', $from_date)
                            ->latest()
                            ->get()
                            ->groupBy(fn ($item) => $item->created_at->format('Y-m-d'));

        $cal = collect([]);

        foreach ($statuses as $key => $status) {
            $cal->prepend($status->count(), $key);
        }

        return $cal;
    }
}
