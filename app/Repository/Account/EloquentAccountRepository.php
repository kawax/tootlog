<?php

namespace App\Repository\Account;

use App\Model\Account;
use App\Model\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Mastodon;

class EloquentAccountRepository implements AccountRepository
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Account::all();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Account::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function oldest()
    {
        return Account::oldest('updated_at')
                      ->where('fails', '<', config('tootlog.account_fails'))
                      ->limit(config('tootlog.account_limit', 3))
                      ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function special()
    {
        return Account::oldest('updated_at')
                      ->where('fails', '<', config('tootlog.account_fails'))
                      ->limit(config('tootlog.account_limit_special', 3))
                      ->whereHas('user', function ($query) {
                          $query->where('special_key', config('tootlog.special_key'));
                      })
                      ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function userAccounts()
    {
        return request()->user()
                        ->accounts()
                        ->latest('updated_at')
                        ->with('server')
                        ->withCount('statuses')
                        ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function openAccounts(User $user)
    {
        return $user->accounts()
                    ->where('locked', false)
                    ->latest('updated_at')
                    ->with('server')
                    ->withCount('statuses')
                    ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getByAcct(string $username, string $domain)
    {
        $url = '://'.$domain.'/@'.$username;

        return Account::where('url', 'like', '%'.$url)->firstOrFail();
    }

    /**
     * {@inheritdoc}
     */
    public function store($user, array $server)
    {
        $data = $user->user;

        $data['account_id'] = $data['id'];
        $data['account_created_at'] = Carbon::parse($data['created_at']);
        $data['token'] = $user->token;
        $data['server_id'] = $server['id'];

        $cond = Arr::only($data, ['account_id', 'username', 'server_id']);

        return request()->user()
                        ->accounts()
                        ->updateOrCreate($cond, $data);
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function updateSince(Account $account, $since_id)
    {
        $account->fill(['since_id' => $since_id])->save();
    }

    /**
     * {@inheritdoc}
     */
    public function exists(string $url): bool
    {
        return Account::where('url', $url)->exists();
    }

    /**
     * {@inheritdoc}
     */
    public function destroy(int $id): void
    {
        Account::destroy($id);
    }
}
