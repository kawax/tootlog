<?php

namespace App\Http\Controllers\Open;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;

use App\Repository\Account\AccountRepositoryInterface as Account;
use App\Repository\Status\StatusRepositoryInterface as Status;

class DateController extends Controller
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

    public function show(User $user, string $date)
    {
        $statuses = $this->statusRepository->openUserStatusesByDate($user, $date);
        $accounts = $this->accountRepository->openAccounts($user);

        return view('open.date')->with(compact('user', 'accounts', 'statuses', 'date'));

    }
}
