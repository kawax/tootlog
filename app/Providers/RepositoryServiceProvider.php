<?php

namespace App\Providers;

use App\Repository\Account\AccountRepository;
use App\Repository\Account\EloquentAccountRepository;
use App\Repository\Server\EloquentServerRepository;
use App\Repository\Server\ServerRepository;
use App\Repository\Status\EloquentStatusRepository;
use App\Repository\Status\StatusRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        //
    }
}
