<?php

namespace App\Http\Controllers\Home;

use App\Jobs\AccountDeleteJob;
use App\Http\Controllers\Controller;
use App\Repository\Account\AccountRepository as Account;

class AccountDeleteController extends Controller
{
    /**
     * @param  Account  $account
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Account $account, int $id)
    {
        $this->authorize('delete', $account->find($id));

        AccountDeleteJob::dispatch($id);

        return redirect('home')->with('message', 'Account delete : start');
    }
}
