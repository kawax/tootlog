<?php

namespace App\Models\Concerns;

use App\Models\Status;
use Illuminate\Contracts\Database\Query\Builder;

trait WithAccountStatus
{
    /**
     * アカウントの個別ポスト.
     */
    public function status(int $id): Status
    {
        return $this->statuses()
            ->withTrashed()
            ->where('status_id', $id)
            ->firstOrFail();
    }

    /**
     * アカウントの全ポスト（公開用）.
     */
    public function openStatuses(?string $search = null): Builder
    {
        return $this->statuses()
            ->when(filled($search), function (Builder $query) use ($search) {
                $query->where('content', 'like', '%'.$search.'%');
            })
            ->latest();
    }
}
