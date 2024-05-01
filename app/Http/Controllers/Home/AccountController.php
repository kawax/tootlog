<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\AccountCreateRequest;
use App\Jobs\Status\GetStatusJob;
use App\Models\Account;
use App\Repository\Server\ServerRepository as Server;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Stringable;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

class AccountController extends Controller
{
    /**
     * Redirect to mastodon server.
     */
    public function redirect(AccountCreateRequest $request, Server $server)
    {
        $domain = $request->string('domain')
            ->trim("/\t\n\r\0\x0B")
            ->pipe(fn (Stringable $domain) => collect(parse_url($domain->value()))->only(['scheme', 'host'])->join('://'))
            ->value();

        $info = $server->firstOrCreate($domain);

        config(['services.mastodon.domain' => $domain]);
        config(['services.mastodon.client_id' => $info['client_id']]);
        config(['services.mastodon.client_secret' => $info['client_secret']]);

        session(['mastodon_domain' => $domain]);

        return Socialite::driver('mastodon')
            ->setScopes(config('services.mastodon.scope', ['read']))
            ->redirect();
    }

    public function callback(Request $request, Server $server): RedirectResponse
    {
        $domain = session('mastodon_domain');
        session()->forget('mastodon_domain');

        $info = $server->firstOrCreate($domain);

        config(['services.mastodon.domain' => $domain]);
        config(['services.mastodon.client_id' => $info['client_id']]);
        config(['services.mastodon.client_secret' => $info['client_secret']]);

        try {
            /**
             * @var SocialiteUser $user
             */
            $user = Socialite::driver('mastodon')->user();

            $account = Account::whereUrl($user->user['url'])
                ->where('user_id', $request->user()->id)
                ->firstOr(fn () => $this->store($user, $info));

            if ($account?->exists() && ! $account->wasRecentlyCreated) {
                $account = $this->update($user, $account);
            }

            GetStatusJob::dispatchSync($account);
        } catch (ClientException $e) {
            logger()->error($e->getMessage());
        }

        return to_route('home');
    }

    /**
     * Update Account.
     */
    protected function update(SocialiteUser $user, Account $account): Account
    {
        $account->fill([
            'token' => $user->token,
            'fails' => 0,
        ])->save();

        return $account;
    }

    /**
     * Create new Account.
     */
    protected function store(SocialiteUser $user, array $info): Account
    {
        $data = $user->user;

        $data['account_id'] = $data['id'];
        $data['account_created_at'] = Carbon::parse($data['created_at']);
        $data['token'] = $user->token;
        $data['server_id'] = $info['id'];

        $cond = Arr::only($data, ['account_id', 'username', 'server_id']);

        return request()->user()->accounts()->updateOrCreate($cond, $data);
    }
}
