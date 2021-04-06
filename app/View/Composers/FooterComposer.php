<?php

namespace App\View\Composers;

use App\Models\Account;
use App\Models\Server;
use App\Models\Status;
use Illuminate\View\View;

class FooterComposer
{
    public function __construct()
    {
        //
    }

    public function compose(View $view)
    {
        $minutes = now()->addDay();

        $footer_servers = cache()->remember('footer_servers', $minutes, function () {
            return Server::count();
        });

        $footer_accounts = cache()->remember('footer_accounts', $minutes, function () {
            return Account::count();
        });

        $footer_statuses = cache()->remember('footer_statuses', $minutes, function () {
            return Status::count();
        });

        $view->with(compact('footer_servers', 'footer_accounts', 'footer_statuses'));
    }
}
