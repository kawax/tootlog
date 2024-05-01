<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use App\Repository\Status\StatusRepository as Status;
use Illuminate\Support\Facades\Gate;

class AccountController extends Controller
{
    /**
     * AccountController constructor.
     *
     * @param  Account  $accountRepository
     * @param  Status  $statusRepository
     */
    public function __construct(
        protected Status $statusRepository
    ) {
    }

    /**
     * @param  User  $user
     * @param  string  $username
     * @param  string  $domain
     * @return mixed
     */
    public function index(User $user, string $username, string $domain)
    {
        $acct = Account::byAcct($username, $domain)->firstOrFail();

        if ($acct->locked) {
            Gate::authorize('show', $acct);
        }

        $statuses = $this->statusRepository->openAcctStatuses($acct);
        $accounts = $user->openAccounts();

        return view('open.acct.index')->with(compact('user', 'acct', 'accounts', 'statuses'));
    }

    /**
     * @param  User  $user
     * @param  string  $username
     * @param  string  $domain
     * @param  string  $status_id
     * @return mixed
     */
    public function show(User $user, string $username, string $domain, string $status_id)
    {
        $acct = Account::byAcct($username, $domain)->firstOrFail();

        /**
         * @var \App\Models\Status $status
         */
        $status = $this->statusRepository->getByAcct($acct, (int) $status_id);

        if ($acct->locked || $status->trashed()) {
            Gate::authorize('show', $acct);
        }

        return view('open.acct.show')->with(compact('user', 'acct', 'status'));
    }
}
