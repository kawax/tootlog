<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Repository\Account\AccountRepository as Account;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function index(Request $request, Account $account)
    {
        $user = $request->user();

        $accounts = $account->userAccounts();

        return view('timeline.index')->with(compact('user', 'accounts'));
    }

    public function acct(Request $request, Account $account, string $username, string $domain)
    {
        $user = $request->user();

        $accounts = $account->userAccounts();

        $acct = $account->getByAcct($username, $domain);

        $this->authorize('show', $acct);

        return view('timeline.acct')->with(compact('user', 'accounts', 'acct'));
    }
}
