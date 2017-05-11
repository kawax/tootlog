<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

use Cache;

use App\Model\Server;
use App\Model\Status;

class FooterComposer
{
    public function __construct()
    {
        //
    }

    public function compose(View $view)
    {
        $minutes = 60;

        $footer_servers = Cache::remember('footer_servers', $minutes, function () {
            return Server::count();
        });

        $footer_statuses = Cache::remember('footer_statuses', $minutes, function () {
            return Status::count();
        });

        $view->with(compact('footer_servers', 'footer_statuses'));
    }
}
