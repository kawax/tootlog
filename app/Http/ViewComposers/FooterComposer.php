<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

use Cache;

use App\Model\Server;
use App\Model\Status;

class FooterComposer
{
    protected $statusRepository;

    public function __construct(Status $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    public function compose(View $view)
    {
        $minutes = 60 * 60 * 24;

        $footer_servers = Cache::remember('footer_servers', $minutes, function () {
            return Server::count();
        });

        $footer_statuses = Cache::remember('footer_statuses', $minutes, function () {
            return Status::count();
        });

        $view->with(compact('footer_servers', 'footer_statuses'));
    }
}
