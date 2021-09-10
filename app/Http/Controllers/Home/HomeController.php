<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Repository\Account\AccountRepository as Account;
use App\Repository\Status\StatusRepository as Status;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param  Request  $request
     * @param  Account  $account
     * @param  Status  $status
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function __invoke(Request $request, Account $account, Status $status)
    {
        $user = $request->user();

        $accounts = $account->userAccounts();
        $statuses = $status->userStatuses();

        return view('home')->with(compact('user', 'accounts', 'statuses'));
    }
}
