<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TimelineController extends Controller
{
    public function index(Request $request)
    {
        /**
         * @var User $user
         */
        $user = $request->user();

        $accounts = $user->allAccounts();

        return view('timeline.index')->with(compact('user', 'accounts'));
    }

    public function acct(Request $request, string $username, string $domain)
    {
        /**
         * @var User $user
         */
        $user = $request->user();

        $acct = Account::byAcct($username, $domain)->firstOrFail();

        Gate::authorize('show', $acct);

        $accounts = $user->allAccounts();

        return view('timeline.acct')->with(compact('user', 'accounts', 'acct'));
    }
}
