<?php

namespace App\Console\Commands\Status;

use App\Jobs\GetStatusJob;
use App\Models\Account;
use Illuminate\Console\Command;

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
     * Execute the console command.
     */
    public function handle(): int
    {
        info('toot:statuses start');

        Account::oldest('updated_at')
            ->where('fails', '<', config('tootlog.account_fails'))
            ->limit(config('tootlog.account_limit', 3))
            ->each(function (Account $account) {
                GetStatusJob::dispatch($account);
            });

        return 0;
    }
}
