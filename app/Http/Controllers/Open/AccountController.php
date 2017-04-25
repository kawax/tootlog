<?php

namespace App\Http\Controllers\Open;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\User;

use App\Repository\Account\AccountRepositoryInterface as Account;
use App\Repository\Status\StatusRepositoryInterface as Status;

class AccountController extends Controller
{
    protected $accountRepository;
    protected $statusRepository;

    public function __construct(Account $accountRepository, Status $statusRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->statusRepository = $statusRepository;
    }

    public function index(User $user, $username, $domain)
    {
        $acct = $this->accountRepository->getByAcct($username, $domain);
        $statuses = $this->statusRepository->openAcctStatuses($acct);
        $accounts = $this->accountRepository->openAccounts($user);

        return view('open.acct.index')->with(compact('user', 'acct', 'accounts', 'statuses'));

    }
}
