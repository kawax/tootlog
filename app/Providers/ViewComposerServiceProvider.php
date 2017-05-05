<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'open.account_list', \App\Http\ViewComposers\AccountComposer::class
        );
        View::composer(
            'side.recents', \App\Http\ViewComposers\RecentComposer::class
        );

        View::composer(
            'side.tags', \App\Http\ViewComposers\TagComposer::class
        );
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
