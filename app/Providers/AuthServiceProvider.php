<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Model\Account;
use App\Model\Status;
use App\Presenter\StatusPresenter;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Account::class         => \App\Policies\AccountPolicy::class,
        Status::class          => \App\Policies\StatusPolicy::class,
        StatusPresenter::class => \App\Policies\StatusPresenterPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
