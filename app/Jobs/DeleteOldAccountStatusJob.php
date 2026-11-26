<?php

namespace App\Jobs;

use App\Models\Account;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DeleteOldAccountStatusJob implements ShouldQueue
{
    use Queueable;

    protected const int MAX_STATUSES = 1000;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Account $account)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // MAX_STATUSES以上の投稿を持つアカウントの古い投稿を少量(50件)ずつ削除。
        // DeleteOldStatusJobが失敗しているのでアカウント指定で実行。

        try {
            $this->account->loadCount('statuses');

            if ($this->account->statuses_count <= self::MAX_STATUSES) {
                return;
            }

            $this->account->statuses()
                ->withTrashed()
                ->oldest()
                ->limit(50)
                ->delete();

            $this->account->touch();

            info('Deleted old statuses for account: '.$this->account->acct.' (remaining: '.$this->account->statuses()->count().')');
        } catch (\Exception $exception) {
            logger()->error('DeleteOldAccountStatusJob: '.$exception->getMessage());
        }
    }
}
