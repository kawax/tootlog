<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AccountController extends Controller
{
    public function index(Request $request, User $user, string $username, string $domain)
    {
        $acct = Account::byAcct($username, $domain)->firstOrFail();

        if ($acct->locked) {
            Gate::authorize('show', $acct);
        }

        $statuses = $acct->openStatuses($request->query('search'))->paginate();
        $accounts = $user->openAccounts();

        return view('open.acct.index')->with(compact('user', 'acct', 'accounts', 'statuses'));
    }

    public function show(User $user, string $username, string $domain, string $status_id)
    {
        $acct = Account::byAcct($username, $domain)->firstOrFail();

        $status = $acct->status($status_id);

        if ($acct->locked || $status->trashed()) {
            Gate::authorize('show', $acct);
        }

        return view('open.acct.show')->with(compact('user', 'acct', 'status'));
    }
}
