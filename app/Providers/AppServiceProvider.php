<?php

namespace App\Providers;

use App\Models\User;
use App\View\Composers\AccountComposer;
use App\View\Composers\RecentComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Revolution\Mastodon\Facades\Mastodon;
use Revolution\Mastodon\MastodonClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Mastodon::macro('instance', fn (): array => /** @var MastodonClient $this */ $this->get('/instance'));

        Paginator::useBootstrapFive();

        view()->composers([
            AccountComposer::class => 'open.account_list',
            RecentComposer::class => 'side.recents',
        ]);

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
