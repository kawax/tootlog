<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repository\Account\AccountRepositoryInterface as Account;
use App\Repository\Status\StatusRepositoryInterface as Status;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @param Account $account
     * @param Status  $status
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request, Account $account, Status $status)
    {
        $user = $request->user();

        $accounts = $account->userAccounts();
        $statuses = $status->userStatuses();

        return view('home')->with(compact('user', 'accounts', 'statuses'));
    }
}
