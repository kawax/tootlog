<?php

namespace App\Jobs;

use App\Models\Account;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DeleteAccountJob implements ShouldQueue
{
    use Queueable;

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
        $this->account->delete();
    }
}
