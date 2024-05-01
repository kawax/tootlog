<?php

namespace App\Providers;

use App\Models\User;
use App\Repository\Server\EloquentServerRepository;
use App\Repository\Server\ServerRepository;
use App\Repository\Status\EloquentStatusRepository;
use App\Repository\Status\StatusRepository;
use App\View\Composers\AccountComposer;
use App\View\Composers\RecentComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Revolution\Mastodon\Facades\Mastodon;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        ServerRepository::class => EloquentServerRepository::class,
        StatusRepository::class => EloquentStatusRepository::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Mastodon::macro('instance', fn (): array => $this->get('/instance'));

        Paginator::useBootstrapFive();

        view()->composers(
            [
                AccountComposer::class => 'open.account_list',
                RecentComposer::class => 'side.recents',
                // TagComposer::class     => 'side.tags',
            ],
        );

        Gate::define('admin', fn (User $user) => $user->id === 1);
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }
}
