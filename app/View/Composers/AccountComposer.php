<?php

namespace App\View\Composers;

use App\Repository\Account\AccountRepository;
use Illuminate\View\View;

class AccountComposer
{
    protected $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function compose(View $view)
    {
        if (! is_null(request()->user)) {
            $view->with('accounts', $this->accountRepository->openAccounts(request()->user));
        }
    }
}
