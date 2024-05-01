<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class AccountDeleteController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(Account $account): RedirectResponse
    {
        Gate::authorize('delete', $account);

        dispatch(fn () => $account->delete());

        return to_route('home')->with('message', 'Account delete : start');
    }
}
