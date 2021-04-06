<?php

namespace App\Providers;

use App\View\Composers\AccountComposer;
use App\View\Composers\RecentComposer;
use App\View\Composers\TagComposer;
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
        view()->composers(
            [
                AccountComposer::class => 'open.account_list',
                RecentComposer::class  => 'side.recents',
                // TagComposer::class     => 'side.tags',
            ]
        );
    }
}
