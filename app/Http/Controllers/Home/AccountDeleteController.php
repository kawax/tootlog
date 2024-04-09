<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Jobs\AccountDeleteJob;
use App\Repository\Account\AccountRepository as Account;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class AccountDeleteController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(Account $account, int $id): RedirectResponse
    {
        Gate::authorize('delete', $account->find($id));

        AccountDeleteJob::dispatch($id);

        return to_route('home')->with('message', 'Account delete : start');
    }
}
