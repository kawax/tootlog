<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repository\Server\ServerRepositoryInterface;
use App\Repository\Server\EloquentServerRepository;

use App\Repository\Account\AccountRepositoryInterface;
use App\Repository\Account\EloquentAccountRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        app()->singleton(
            ServerRepositoryInterface::class,
            EloquentServerRepository::class
        );

        app()->singleton(
            AccountRepositoryInterface::class,
            EloquentAccountRepository::class
        );
    }
}
