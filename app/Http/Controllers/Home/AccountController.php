<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\AccountCreateRequest;
use App\Jobs\Status\GetStatusJob;
use App\Models\Account;
use App\Models\Server;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Revolution\Mastodon\Facades\Mastodon;

class AccountController extends Controller
{
    /**
     * Redirect to mastodon server.
     */
    public function redirect(AccountCreateRequest $request)
    {
        $domain = $request->string('domain')
            ->trim()
            ->pipe(fn (Stringable $domain) => collect(parse_url($domain->value()))->only(['scheme', 'host'])->join('://'))
            ->value();

        $server = $this->server($domain);

        config(['services.mastodon.domain' => $domain]);
        config(['services.mastodon.client_id' => $server->client_id]);
        config(['services.mastodon.client_secret' => $server->client_secret]);

        session(['mastodon_domain' => $domain]);

        return Socialite::driver('mastodon')
            ->setScopes(config('services.mastodon.scope', ['read']))
            ->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        $domain = session()->pull('mastodon_domain');

        $server = $this->server($domain);

        config(['services.mastodon.domain' => $domain]);
        config(['services.mastodon.client_id' => $server->client_id]);
        config(['services.mastodon.client_secret' => $server->client_secret]);

        try {
            /**
             * @var SocialiteUser $user
             */
            $user = Socialite::driver('mastodon')->user();

            $account = Account::whereUrl($user->user['url'])
                ->where('user_id', $request->user()->id)
                ->firstOr(fn () => $this->store($user, $server));

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
    protected function store(SocialiteUser $user, Server $server): Account
    {
        $data = $user->user;

        $data['account_id'] = $data['id'];
        $data['account_created_at'] = Carbon::parse($data['created_at']);
        $data['token'] = $user->token;
        $data['server_id'] = $server->id;

        $cond = Arr::only($data, ['account_id', 'username', 'server_id']);
        Arr::forget($data, ['account_id', 'username', 'server_id']);

        return request()->user()->accounts()->updateOrCreate($cond, $data);
    }

    /**
     * Server info.
     */
    protected function server(string $domain): Server
    {
        $domain = Str::trim($domain);

        $server = Server::whereDomain($domain)->first();

        if ($server?->exists() && Str::startsWith($server->redirect_uri, url('/'))) {
            return $server;
        }

        $client_name = config('app.name');
        $redirect_uris = config('services.mastodon.redirect');
        $scopes = implode(' ', config('services.mastodon.scope'));

        $info = Mastodon::domain($domain)
            ->createApp($client_name, $redirect_uris, $scopes, config('app.url'));

        $info['app_id'] = $info['id'];

        return Server::updateOrCreate(
            ['domain' => $domain],
            $info,
        );
    }
}
