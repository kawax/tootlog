<?php

namespace App\Jobs;

use App\Models\Account;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DeleteOldStatusJob implements ShouldQueue
{
    use Queueable;

    protected const int MAX_STATUSES = 1000;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // MAX_STATUSES以上の投稿を持つアカウントの古い投稿を少量(50件)ずつ削除。

        $account = Account::with('statuses')
            ->withCount('statuses')
            ->having('statuses_count', '>', self::MAX_STATUSES)
            ->oldest()
            ->first();

        $account->statuses()
            ->withTrashed()
            ->oldest()
            ->limit(50)
            ->delete();

        $account->touch();

        info('Deleted old statuses for account: '.$account->acct.' (remaining: '.$account->statuses()->count().')');
    }
}
