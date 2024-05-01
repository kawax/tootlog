<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Collection;

trait WithUserAccount
{
    /**
     * ユーザーのアカウント.
     */
    public function allAccounts(): Collection
    {
        return $this->accounts()
            ->latest('updated_at')
            ->with('server')
            ->withCount('statuses')
            ->get();
    }

    /**
     * ユーザーのアカウント（公開用）.
     */
    public function openAccounts(): Collection
    {
        return $this->accounts()
            ->where('locked', false)
            ->latest('updated_at')
            ->with('server')
            ->withCount('statuses')
            ->get();
    }
}
