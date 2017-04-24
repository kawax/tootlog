<?php

namespace App\Http\Controllers\Open;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\User;

use App\Repository\Account\AccountRepositoryInterface as Account;
use App\Repository\Status\StatusRepositoryInterface as Status;

class UserController extends Controller
{
    public function index(User $user, Account $accountRepository, Status $statusRepository)
    {
        $statuses = $statusRepository->openStatuses($user);
        $accounts = $accountRepository->openAccounts($user);

        return view('open.user')->with(compact('user', 'accounts', 'statuses'));

    }
}
