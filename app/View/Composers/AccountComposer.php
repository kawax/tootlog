<?php

namespace App\View\Composers;

use App\Repository\Account\AccountRepository;
use Illuminate\View\View;

class AccountComposer
{
    public function __construct(protected AccountRepository $accountRepository)
    {
    }

    public function compose(View $view)
    {
        if (! is_null(request()->user)) {
            $view->with('accounts', $this->accountRepository->openAccounts(request()->user));
        }
    }
}
