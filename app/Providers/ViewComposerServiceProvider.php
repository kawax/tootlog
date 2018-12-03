<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            'open.account_list',
            \App\Http\ViewComposers\AccountComposer::class
        );
        view()->composer(
            'side.recents',
            \App\Http\ViewComposers\RecentComposer::class
        );

        view()->composer(
            'side.tags',
            \App\Http\ViewComposers\TagComposer::class
        );

        view()->composer(
            'layouts.footer',
            \App\Http\ViewComposers\FooterComposer::class
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
