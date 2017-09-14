<?php

namespace App\Repository\Account;

use App\Model\User;
use App\Model\Account;
use Cake\Chronos\Chronos;

use Mastodon;

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
     * @inheritDoc
     */
    public function find($id)
    {
        return Account::find($id);
    }

    /**
     *
     * @inheritDoc
     */
    public function oldest()
    {
        $accounts = Account::oldest('updated_at')
                           ->where('fails', '<', config('tootlog.account_fails'))
                           ->limit(config('tootlog.account_limit'))
                           ->get();

        return $accounts;
    }

    /**
     * @inheritDoc
     */
    public function userAccounts()
    {
        $accounts = request()->user()
                             ->accounts()
                             ->latest('updated_at')
                             ->with('server')
                             ->withCount('statuses')
                             ->get();

        return $accounts;
    }

    /**
     * @inheritDoc
     */
    public function openAccounts(User $user)
    {
        $accounts = $user->accounts()
                         ->where('locked', false)
                         ->latest('updated_at')
                         ->with('server')
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
    public function store($user, array $server)
    {
        $data = $user->user;

        $data['account_id'] = $data['id'];
        $data['account_created_at'] = Chronos::parse($data['created_at']);
        $data['token'] = $user->token;
        $data['server_id'] = $server['id'];

        $cond = array_only($data, ['account_id', 'username', 'server_id']);

        $account = request()->user()
                            ->accounts()
                            ->updateOrCreate($cond, $data);

        return $account;
    }

    /**
     * @inheritDoc
     */
    public function update($user)
    {
        $data = [];

        $data['token'] = $user->token;
        $data['fails'] = 0;

        $account = Account::where('url', $user->user['url'])
                          ->where('user_id', request()->user()->id)
                          ->firstOrFail();

        $account->fill($data)->save();

        return $account;
    }

    /**
     * @inheritDoc
     */
    public function refresh(Account $account)
    {
        $data = Mastodon::domain($account->server->domain)
                        ->token($account->token)
                        ->verifyCredentials();

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
