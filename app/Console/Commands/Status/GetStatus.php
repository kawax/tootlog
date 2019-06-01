<?php

namespace App\Console\Commands\Status;

use Illuminate\Console\Command;
use App\Jobs\Status\GetStatusJob;
use App\Repository\Account\AccountRepository as Account;

class GetStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toot:statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get statuses';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Account $account)
    {
        info('toot:statuses start');

        $accounts = $account->oldest();

        foreach ($accounts as $account) {
            GetStatusJob::dispatch($account);
        }
    }
}
