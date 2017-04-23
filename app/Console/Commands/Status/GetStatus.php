<?php

namespace App\Console\Commands\Status;

use Illuminate\Console\Command;

use App\Repository\Account\AccountRepositoryInterface as Account;

use App\Jobs\Status\GetStatusJob;

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
    protected $description = 'Command description';

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
        $accounts = $account->all();

        foreach ($accounts as $account){
            dispatch((new GetStatusJob($account)));
        }
    }
}
