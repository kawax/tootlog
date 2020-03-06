<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\User;
use App\Repository\Account\AccountRepository as Account;
use App\Repository\Status\StatusRepository as Status;

class CalendarController extends Controller
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
     * @param  Account  $accountRepository
     * @param  Status  $statusRepository
     */
    public function __construct(Account $accountRepository, Status $statusRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->statusRepository = $statusRepository;
    }

    public function index(User $user)
    {
        return $this->statusRepository->openCalendar($user);
    }

    public function acct(User $user, string $username, string $domain)
    {
        $acct = $this->accountRepository->getByAcct($username, $domain);

        if ($acct->locked) {
            $this->authorize('show', $acct);
        }

        return $this->statusRepository->openAcctCalendar($acct);
    }
}
