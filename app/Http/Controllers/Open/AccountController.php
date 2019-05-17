<?php

namespace App\Http\Controllers\Open;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\User;

use App\Repository\Account\AccountRepositoryInterface as Account;
use App\Repository\Status\StatusRepositoryInterface as Status;

use OpenGraph;
use Twitter;

class AccountController extends Controller
{
    /**
     * @var Account
     */
    protected $accountRepository;

    /**
     * @var Status
     */
    protected $statusRepository;

    /**
     * AccountController constructor.
     *
     * @param  Account  $accountRepository
     * @param  Status  $statusRepository
     */
    public function __construct(Account $accountRepository, Status $statusRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->statusRepository = $statusRepository;
    }

    /**
     * @param  User  $user
     * @param  string  $username
     * @param  string  $domain
     *
     * @return mixed
     */
    public function index(User $user, string $username, string $domain)
    {
        $acct = $this->accountRepository->getByAcct($username, $domain);

        if ($acct->locked) {
            $this->authorize('show', $acct);
        }

        $title = $acct->acct.' - '.config('app.name', 'tootlog');
        OpenGraph::setSiteName(config('app.name', 'tootlog'));
        OpenGraph::setDescription($acct->note);
        OpenGraph::setTitle($title);
        OpenGraph::setUrl(route('open.account.index', [$user, $acct->username, $acct->domain]));
        OpenGraph::addProperty('type', 'profile');
        OpenGraph::addImage($acct->avatar);

        Twitter::setTitle($title);
        Twitter::setType('summary');

        $statuses = $this->statusRepository->openAcctStatuses($acct);
        $accounts = $this->accountRepository->openAccounts($user);

        return view('open.acct.index')->with(compact('user', 'acct', 'accounts', 'statuses'));
    }

    /**
     * @param  User  $user
     * @param  string  $username
     * @param  string  $domain
     * @param  string  $status_id
     *
     * @return mixed
     */
    public function show(User $user, string $username, string $domain, string $status_id)
    {
        $acct = $this->accountRepository->getByAcct($username, $domain);

        /**
         * @var \App\Model\Status $status
         */
        $status = $this->statusRepository->getByAcct($acct, $status_id);

        if ($acct->locked or $status->trashed()) {
            $this->authorize('show', $acct);
        }

        $title = $acct->acct.' - '.config('app.name', 'tootlog');

        OpenGraph::setSiteName(config('app.name', 'tootlog'));
        OpenGraph::setDescription($status->content);
        OpenGraph::setTitle($title);
        OpenGraph::setUrl(route('open.account.show', [$user, $acct->username, $acct->domain, $status_id]));
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addImage($acct->avatar);

        Twitter::setTitle($title);
        Twitter::setType('summary');

        return view('open.acct.show')->with(compact('user', 'acct', 'status'));
    }
}
