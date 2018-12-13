<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

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
        \Gate::define('admin-logs', function ($user) {
            return $user->isAdmin();
        });

        \Mastodon::macro('instance', function () {
            return $this->get('/instance');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //        if ($this->app->isLocal()) {
        //            $this->app->register(TelescopeServiceProvider::class);
        //        }
    }
}
