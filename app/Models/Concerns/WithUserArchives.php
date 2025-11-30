<?php

namespace App\Models\Concerns;

use Illuminate\Support\Collection;

trait WithUserArchives
{
    /**
     * Recentパーツ（公開用）.
     */
    public function openRecents(): Collection
    {
        return cache()->remember('recents/open/'.$this->id, now()->addDay(), function () {
            $date_format = app()->isProduction()
                ? 'DATE_FORMAT(statuses.created_at,"%Y-%m-%d")'
                : 'STRFTIME("%Y-%m-%d", statuses.created_at)';

            return $this->statuses()
                ->select(['statuses.id', 'statuses.created_at', 'statuses.account_id'])
                ->selectRaw($date_format.' as date')
                ->with(['account:id,locked'])
                ->where('accounts.locked', false)
                ->latest('date')
                ->cursor()
                ->groupBy('date')
                ->take(10)
                ->map(fn ($item) => $item->count())
                ->collect();
        });
    }

    /**
     * Archivesページ用.
     */
    public function openArchives(): Collection
    {
        return cache()->remember('archives/'.$this->id, now()->addDay(), function () {
            $date_format = app()->isProduction()
                ? 'DATE_FORMAT(statuses.created_at,"%Y-%m-%d")'
                : 'STRFTIME("%Y-%m-%d", statuses.created_at)';

            return $this->statuses()
                ->select(['statuses.id', 'statuses.created_at', 'statuses.account_id'])
                ->selectRaw($date_format.' as date')
                ->with(['account:id,locked'])
                ->where('accounts.locked', false)
                ->latest('date')
                ->cursor()
                ->groupBy('date')
                ->map(fn ($item) => $item->count())
                ->collect();
        });
    }
}
