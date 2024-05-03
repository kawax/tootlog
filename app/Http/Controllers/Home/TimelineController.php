<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\View\View;

class TimelineController extends Controller
{
    public function index(Request $request): View
    {
        /**
         * @var User $user
         */
        $user = $request->user();

        $accounts = $user->allAccounts();

        return view('timeline.index')->with(compact('accounts'));
    }

    public function acct(Request $request, string $username, string $domain): View
    {
        $acct = Account::byAcct($username, $domain)->firstOrFail();

        Gate::authorize('show', $acct);

        /**
         * @var User $user
         */
        $user = $request->user();

        $accounts = $user->allAccounts();

        return view('timeline.acct')->with(compact('accounts', 'acct'));
    }
}
