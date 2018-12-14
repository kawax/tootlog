<?php

namespace App\Http\Controllers\Home;

use GuzzleHttp\Exception\ClientException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Account\AccountCreateRequest;

use App\Repository\Server\ServerRepositoryInterface as ServerRepository;
use App\Repository\Account\AccountRepositoryInterface as AccountRepository;

use App\Jobs\Status\GetStatusJob;

use Socialite;

class AccountController extends Controller
{
    /**
     * Redirect to mastodon server.
     *
     * @param  AccountCreateRequest $request
     * @param  ServerRepository     $server
     *
     * @return \Illuminate\Http\Response
     */
    public function redirect(AccountCreateRequest $request, ServerRepository $server)
    {
        $domain = $request->input('domain');
        $domain = trim($domain, "/\t\n\r\0\x0B");
        $url = parse_url($domain);
        $domain = $url['scheme'] . '://' . $url['host'];

        $info = $server->firstOrCreate($domain);

        config(['services.mastodon.domain' => $domain]);
        config(['services.mastodon.client_id' => $info['client_id']]);
        config(['services.mastodon.client_secret' => $info['client_secret']]);

        info(config('services.mastodon.redirect'));

        session(['mastodon_domain' => $domain]);

        return Socialite::driver('mastodon')
                        ->setScopes(config('services.mastodon.scope', ['read']))
                        ->redirect();
    }

    /**
     * @param Request           $request
     * @param AccountRepository $account
     * @param ServerRepository  $server
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function callback(Request $request, AccountRepository $account, ServerRepository $server)
    {
        $domain = session('mastodon_domain');
        session(['mastodon_domain' => null]);

        $info = $server->firstOrCreate($domain);

        config(['services.mastodon.domain' => $domain]);
        config(['services.mastodon.client_id' => $info['client_id']]);
        config(['services.mastodon.client_secret' => $info['client_secret']]);

        info(config('services.mastodon.redirect'));

        try {
            $user = Socialite::driver('mastodon')->user();
            //                        dd($user);

            if ($account->exists($user->user['url'])) {
                $acct = $account->update($user);
            } else {
                $acct = $account->store($user, $info);
            }

            dispatch_now(new GetStatusJob($acct));
        } catch (ClientException $e) {
            logger()->error($e->getMessage());
        }

        return redirect('/home');
    }
}
