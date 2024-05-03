<?php

namespace App\Models\Concerns;

use App\Models\Tag;
use Illuminate\Contracts\Database\Query\Builder;

trait WithUserStatus
{
    /**
     * ユーザーの全ポスト.
     */
    public function allStatuses(?string $search = null): Builder
    {
        return $this->statuses()
            ->when(filled($search), function (Builder $query) use ($search) {
                $query->where('content', 'like', '%'.$search.'%');
            })
            ->latest()
            ->withTrashed();
    }

    /**
     * ユーザーの全ポスト（公開用）.
     */
    public function openStatuses(?string $search = null): Builder
    {
        return $this->statuses()
            ->when(filled($search), function (Builder $query) use ($search) {
                $query->where('content', 'like', '%'.$search.'%');
            })
            ->where('accounts.locked', false)
            ->latest();
    }

    /**
     * 日付指定のポスト（公開用）.
     */
    public function openStatusesByDate(string $year, ?string $month = null, ?string $day = null): Builder
    {
        return $this->statuses()
            ->where('accounts.locked', false)
            ->whereYear('statuses.created_at', $year)
            ->when(filled($month), fn (Builder $query) => $query->whereMonth('statuses.created_at', $month))
            ->when(filled($day), fn (Builder $query) => $query->whereDay('statuses.created_at', $day))
            ->latest();
    }

    public function openTagStatuses(Tag $tag, ?string $search = null): Builder
    {
        $accounts = $this->accounts()->where('locked', false)->pluck('id');

        return $tag->statuses()
            ->when(filled($search), function (Builder $query) use ($search) {
                $query->where('content', 'like', '%'.$search.'%');
            })
            ->whereIn('statuses.account_id', $accounts)
            ->latest();
    }
}
