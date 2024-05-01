<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Request;
use Illuminate\View\View;

class AccountComposer
{
    public function compose(View $view): void
    {
        if (Request::route()->hasParameter('user')) {
            $view->with('accounts', request()->route('user')->openAccounts());
        }
    }
}
