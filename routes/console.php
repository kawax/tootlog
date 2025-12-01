<?php

use App\Models\Status;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('toot:statuses-special')
    ->hourlyAt(10);

Schedule::command('toot:statuses')
    ->hourlyAt(30);

Schedule::command('toot:info')
    ->dailyAt('08:00')
    ->when(app()->isProduction());

Schedule::command('toot:version')
    ->timezone('Asia/Tokyo')
    ->dailyAt('23:20');

Schedule::command('horizon:snapshot')->everyFiveMinutes();

Schedule::command('queue:prune-failed', ['--hours' => 48])->hourly();

Artisan::command('welcome:test', function () {
    $this->info(Status::query()
        ->join('accounts', 'statuses.account_id', '=', 'accounts.id')
        ->where('accounts.locked', false)
        ->whereNotNull('statuses.content')
        ->where('statuses.content', '!=', '')
        ->select(['statuses.content'])
        ->limit(100)
        ->get()
        ->map(fn ($item) => str($item->content)->stripTags()->limit(200)->toString())
        ->toPrettyJson(JSON_UNESCAPED_UNICODE));
});
