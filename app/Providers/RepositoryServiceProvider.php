<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repository\Server\ServerRepository;
use App\Repository\Server\EloquentServerRepository;

use App\Repository\Account\AccountRepository;
use App\Repository\Account\EloquentAccountRepository;

use App\Repository\Status\StatusRepository;
use App\Repository\Status\EloquentStatusRepository;

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
            ServerRepository::class,
            EloquentServerRepository::class
        );

        app()->singleton(
            AccountRepository::class,
            EloquentAccountRepository::class
        );

        app()->singleton(
            StatusRepository::class,
            EloquentStatusRepository::class
        );
    }
}
