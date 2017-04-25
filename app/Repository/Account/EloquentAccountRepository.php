<?php

namespace App\Repository\Account;

use App\Model\Account;
use Cake\Chronos\Chronos;
use Revolution\Mastodon\Account as MastodonAccount;

class EloquentAccountRepository implements AccountRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function all()
    {
        $accounts = Account::all();

        return $accounts;
    }

    /**
     *
     * @inheritDoc
     */
    public function oldest()
    {
        $accounts = Account::oldest('updated_at')->limit(config('tootlog.account_limit'))->get();

        return $accounts;
    }

    /**
     * @inheritDoc
     */
    public function userAccounts()
    {
        $accounts = request()->user()
                             ->accounts()
            //                             ->with('server')
                             ->withCount('statuses')
                             ->get();

        return $accounts;
    }

    /**
     * @inheritDoc
     */
    public function openAccounts($user)
    {
        $accounts = $user->accounts()
                         ->where('locked', false)
            //                             ->with('server')
                         ->withCount('statuses')
                         ->get();

        return $accounts;
    }

    /**
     * @inheritDoc
     */
    public function getByAcct(string $username, string $domain)
    {
        $url = '://' . $domain . '/@' . $username;

        return Account::where('url', 'like', '%' . $url)->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function store($user, $server)
    {
        $data = $user->user;

        $data['account_id'] = $data['id'];
        $data['account_created_at'] = Chronos::parse($data['created_at']);
        $data['token'] = $user->token;
        $data['server_id'] = $server->id;

        $cond = array_only($data, ['account_id', 'username', 'server_id']);

        $account = request()->user()
                            ->accounts()
                            ->updateOrCreate($cond, $data);

        return $account;
    }

    /**
     * @inheritDoc
     */
    public function refresh(Account $account)
    {
        $mstdn = new MastodonAccount();
        $data = $mstdn->token($account->token)->verify_credentials($account->server->domain);

        $account->fill($data)->save();

        return $account;
    }

    /**
     * @inheritDoc
     */
    public function updateSince(Account $account, $since_id)
    {
        $account->fill(['since_id' => $since_id])->save();
    }

    /**
     * @inheritDoc
     */
    public function exists(string $url): bool
    {
        return Account::where('url', $url)->exists();
    }

}
