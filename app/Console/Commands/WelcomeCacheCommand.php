<?php

namespace App\Console\Commands;

use App\Models\Status;
use Illuminate\Console\Command;

class WelcomeCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'welcome:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache statuses for welcome page api';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $statuses = Status::query()
            ->join('accounts', 'statuses.account_id', '=', 'accounts.id')
            ->where('accounts.locked', false)
            ->whereNotNull('statuses.content')
            ->where('statuses.content', '!=', '')
            ->whereNot('statuses.content', 'LIKE', '@%')
            ->select(['statuses.content'])
            ->latest('statuses.id')
            ->limit(100)
            ->get()
            ->map(fn ($item) => str($item->content)->stripTags()->limit(200)->toString())
            ->toPrettyJson(JSON_UNESCAPED_UNICODE);

        cache()->forever('welcome_statuses', $statuses);

        $this->info('Welcome statuses cached.');
        $this->info($statuses);
    }
}
