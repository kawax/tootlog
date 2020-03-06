<?php

namespace App\Jobs;

use App\Repository\Account\AccountRepository as Account;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AccountDeleteJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var int
     */
    protected $id;

    /**
     * Create a new job instance.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @param  Account  $account
     *
     * @return void
     */
    public function handle(Account $account)
    {
        $account->destroy($this->id);
    }
}
