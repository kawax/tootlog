<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;

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

        Blade::directive('inline_css', function ($path) {
            $css = File::get(public_path(trim($path, "'")));

            return '<style type="text/css">' . $css . '</style>';
        });
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
