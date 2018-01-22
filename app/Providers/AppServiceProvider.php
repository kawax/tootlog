<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Horizon::auth(function (Request $request) {
            return $request->user()->isAdmin();
        });

        //laravel-log-viewer表示可能
        \Gate::define('admin-logs', function ($user) {
            return $user->isAdmin();
        });

        Paginator::defaultView('pagination::bootstrap-4');
        Paginator::defaultSimpleView('pagination::simple-bootstrap-4');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \Mastodon::macro('instance', function () {
            return $this->get('/instance');
        });
    }
}
