<?php

namespace App\Http\Controllers\Open;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\User;

use App\Repository\Account\AccountRepositoryInterface as Account;
use App\Repository\Status\StatusRepositoryInterface as Status;

class AccountController extends Controller
{
    /**
     * @var Account
     */
    protected $accountRepository;

    /**
     * @var Status
     */
    protected $statusRepository;

    /**
     * AccountController constructor.
     *
     * @param Account $accountRepository
     * @param Status  $statusRepository
     */
    public function __construct(Account $accountRepository, Status $statusRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->statusRepository = $statusRepository;
    }

    /**
     * @param User   $user
     * @param string $username
     * @param string $domain
     *
     * @return mixed
     */
    public function index(User $user, string $username, string $domain)
    {
        $acct = $this->accountRepository->getByAcct($username, $domain);

        if ($acct->locked) {
            $this->authorize('show', $acct);
        }

        $statuses = $this->statusRepository->openAcctStatuses($acct);
        $accounts = $this->accountRepository->openAccounts($user);

        return view('open.acct.index')->with(compact('user', 'acct', 'accounts', 'statuses'));
    }

    /**
     * @param User   $user
     * @param string $username
     * @param string $domain
     * @param string $status_id
     *
     * @return mixed
     */
    public function show(User $user, string $username, string $domain, string $status_id)
    {
        $acct = $this->accountRepository->getByAcct($username, $domain);

        if ($acct->locked) {
            $this->authorize('show', $acct);
        }

        $status = $this->statusRepository->getByAcct($acct, $status_id);
        $accounts = $this->accountRepository->openAccounts($user);

        return view('open.acct.show')->with(compact('user', 'acct', 'accounts', 'status'));
    }
}
