<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Revolution\Mastodon\Facades\Mastodon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //laravel-log-viewer表示可能
        Gate::define('admin-logs', fn ($user) => $user->isAdmin());

        Mastodon::macro('instance', fn (): array => $this->get('/instance'));

        Paginator::useBootstrapFive();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
