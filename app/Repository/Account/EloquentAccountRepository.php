<?php

namespace App\Repository\Account;

use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Revolution\Mastodon\Facades\Mastodon;

class EloquentAccountRepository implements AccountRepository
{
    public function all(): Collection
    {
        return Account::all();
    }

    public function find(int $id): Account
    {
        return Account::find($id);
    }

    public function oldest(): Collection
    {
        return Account::oldest('updated_at')
            ->where('fails', '<', config('tootlog.account_fails'))
            ->limit(config('tootlog.account_limit', 3))
            ->get();
    }

    public function special(): Collection
    {
        return Account::oldest('updated_at')
            ->where('fails', '<', config('tootlog.account_fails'))
            ->limit(config('tootlog.account_limit_special', 3))
            ->whereHas('user', function ($query) {
                $query->where('special_key', config('tootlog.special_key'));
            })
            ->get();
    }

    public function userAccounts(): Collection
    {
        return request()->user()
            ->accounts()
            ->latest('updated_at')
            ->with('server')
            ->withCount('statuses')
            ->get();
    }

    public function openAccounts(User $user): Collection
    {
        return $user->accounts()
            ->where('locked', false)
            ->latest('updated_at')
            ->with('server')
            ->withCount('statuses')
            ->get();
    }

    public function getByAcct(string $username, string $domain): Account
    {
        $url = '://'.$domain.'/@'.$username;

        return Account::where('url', 'like', '%'.$url)->firstOrFail();
    }

    public function store(mixed $user, array $server): Account
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

    public function update(mixed $user): Account
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

    public function refresh(Account $account): Account
    {
        $data = Mastodon::domain($account->server->domain)
            ->token($account->token)
            ->verifyCredentials();

        $account->fill($data)->save();

        return $account;
    }

    public function updateSince(Account $account, int $since_id): void
    {
        $account->fill(['since_id' => $since_id])->save();
    }

    public function exists(string $url): bool
    {
        return Account::where('url', $url)->exists();
    }

    public function destroy(int $id): void
    {
        Account::destroy($id);
    }
}
