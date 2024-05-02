<?php

namespace App\Console\Commands\Status;

use App\Jobs\GetStatusJob;
use App\Models\Account;
use Illuminate\Console\Command;

class GetUserStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toot:user-statuses {account=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get account statuses (test command)';

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
     */
    public function handle(): int
    {
        info('toot:user-statuses start');

        $account = Account::findOrFail($this->argument('account'));

        GetStatusJob::dispatch($account);

        return 0;
    }
}
