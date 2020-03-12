<?php

namespace App\View\Composers;

use App\Model\Account;
use App\Model\Server;
use App\Model\Status;
use Illuminate\View\View;

class FooterComposer
{
    public function __construct()
    {
        //
    }

    public function compose(View $view)
    {
        $minutes = now()->addMinutes(60);

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
