<?php

namespace App\View\Composers;

use Illuminate\View\View;

class AccountComposer
{
    public function __construct()
    {
    }

    public function compose(View $view): void
    {
        if (! is_null(request()->user)) {
            $view->with('accounts', request()->user()->allAccounts());
        }
    }
}
