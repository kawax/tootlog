<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\AccountCreateRequest;
use App\Jobs\Status\GetStatusJob;
use App\Repository\Account\AccountRepository as Account;
use App\Repository\Server\ServerRepository as Server;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Stringable;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User;

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

    public function callback(Request $request, Account $account, Server $server): RedirectResponse
    {
        $domain = session('mastodon_domain');
        session()->forget('mastodon_domain');

        $info = $server->firstOrCreate($domain);

        config(['services.mastodon.domain' => $domain]);
        config(['services.mastodon.client_id' => $info['client_id']]);
        config(['services.mastodon.client_secret' => $info['client_secret']]);

        try {
            /**
             * @var User $user
             */
            $user = Socialite::driver('mastodon')->user();

            if ($account->exists($user->user['url'])) {
                $acct = $account->update($user);
            } else {
                $acct = $account->store($user, $info);
            }

            GetStatusJob::dispatchSync($acct);
        } catch (ClientException $e) {
            logger()->error($e->getMessage());
        }

        return to_route('home');
    }
}
