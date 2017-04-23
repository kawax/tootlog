<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

use App\Http\Requests\Account\AccountCreateRequest;

use App\Repository\Server\ServerRepositoryInterface as Server;
use App\Repository\Account\AccountRepositoryInterface as Account;

use Socialite;

class AccountController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  AccountCreateRequest $request
     * @param  Server               $server
     *
     * @return \Illuminate\Http\Response
     */
    public function redirect(AccountCreateRequest $request, Server $server)
    {
        $domain = $request->input('domain');
        $domain = trim($domain, "/\t\n\r\0\x0B");

        $info = $server->firstOrCreate($domain);

        config(['services.mastodon.domain' => $domain]);
        config(['services.mastodon.client_id' => $info->client_id]);
        config(['services.mastodon.client_secret' => $info->client_secret]);

        session(['mastodon_domain' => $domain]);

        return Socialite::driver('mastodon')->redirect();
    }

    public function callback(Request $request, Account $account, Server $server)
    {
        $domain = session('mastodon_domain');
        session(['mastodon_domain' => null]);

        $info = $server->firstOrCreate($domain);

        config(['services.mastodon.domain' => $domain]);
        config(['services.mastodon.client_id' => $info->client_id]);
        config(['services.mastodon.client_secret' => $info->client_secret]);

        try {
            $user = Socialite::driver('mastodon')->user();
//            dd($user);
            $acct = $account->store($user, $info);
//            dd($acct);

        } catch (ClientException $e) {
            \Log::error($e->getMessage());
        }

        return redirect('/home');
    }
}
