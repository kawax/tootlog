<?php

namespace App\Console\Commands\Status;

use Illuminate\Console\Command;

use App\Repository\Account\AccountRepositoryInterface as Account;

use App\Jobs\Status\GetStatusJob;

class GetUserStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toot:user-statuses {user=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get user statuses';

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
        \Log::info('toot:user-statuses start');

        $account = $account->find($this->argument('user'));

        dispatch((new GetStatusJob($account)));
    }
}
