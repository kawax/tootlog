<?php

namespace App\Providers;

use App\Repository\Account\AccountRepository;
use App\Repository\Account\EloquentAccountRepository;
use App\Repository\Server\EloquentServerRepository;
use App\Repository\Server\ServerRepository;
use App\Repository\Status\EloquentStatusRepository;
use App\Repository\Status\StatusRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Revolution\Mastodon\Facades\Mastodon;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        ServerRepository::class => EloquentServerRepository::class,
        AccountRepository::class => EloquentAccountRepository::class,
        StatusRepository::class => EloquentStatusRepository::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Mastodon::macro('instance', fn (): array => $this->get('/instance'));

        Paginator::useBootstrapFive();
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }
}
