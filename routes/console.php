<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

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

Schedule::command('welcome:cache')->everyFourHours();
