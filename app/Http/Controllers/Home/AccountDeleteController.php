<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Jobs\AccountDeleteJob;
use App\Repository\Account\AccountRepositoryInterface as AccountRepository;

class AccountDeleteController extends Controller
{
    /**
     * @param AccountRepository $account
     * @param int               $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(AccountRepository $account, int $id)
    {
        $this->authorize('delete', $account->find($id));

        AccountDeleteJob::dispatch($id);

        return redirect('home')->with('message', 'Account delete : start');
    }
}
