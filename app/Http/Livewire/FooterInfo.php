<?php

namespace App\Http\Livewire;

use App\Models\Account;
use App\Models\Server;
use App\Models\Status;
use Livewire\Component;

class FooterInfo extends Component
{
    public int $footer_servers = 0;

    public int $footer_accounts = 0;

    public int $footer_statuses = 0;

    public function loadInfo()
    {
        $minutes = now()->addDay();

        $this->footer_servers = cache()->remember(
            'footer_servers',
            $minutes,
            fn () => Server::count()
        );

        $this->footer_accounts = cache()->remember(
            'footer_accounts',
            $minutes,
            fn () => Account::count()
        );

        $this->footer_statuses = cache()->remember(
            'footer_statuses',
            $minutes,
            fn () => Status::count()
        );
    }

    public function render()
    {
        return view('livewire.footer-info');
    }
}
