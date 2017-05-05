<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

use App\Repository\Account\AccountRepositoryInterface as AccountRepository;

class AccountComposer
{
    protected $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function compose(View $view)
    {
        if (!is_null(request()->user)) {
            $view->with('accounts', $this->accountRepository->openAccounts(request()->user));
        }
    }
}
