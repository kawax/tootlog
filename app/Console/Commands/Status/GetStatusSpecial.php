<?php

namespace App\Console\Commands\Status;

use App\Jobs\GetStatusJob;
use App\Models\Account;
use Illuminate\Console\Command;
use Illuminate\Contracts\Database\Query\Builder;

class GetStatusSpecial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toot:statuses-special';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get statuses. Special';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        info('toot:statuses-special start');

        Account::oldest('updated_at')
            ->where('fails', '<', config('tootlog.account_fails'))
            ->limit(config('tootlog.account_limit_special', 3))
            ->whereHas('user', function (Builder $query) {
                $query->where('special_key', config('tootlog.special_key'));
            })
            ->each(function (Account $account) {
                GetStatusJob::dispatch($account);
            });

        return 0;
    }
}
