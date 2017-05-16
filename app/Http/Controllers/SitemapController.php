<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Roumen\Sitemap\Sitemap;

use Cake\Chronos\Chronos;
use App\Model\User;
use App\Model\Account;

class SitemapController extends Controller
{
    public function __invoke(Sitemap $sitemap)
    {
        $sitemap->setCache('tootlog.sitemaps', 60);

        if (!$sitemap->isCached()) {
            $sitemap->add(url('/'), Chronos::now(), '0.2', 'weekly');

            foreach (User::latest()->cursor() as $user) {
                $sitemap->add(route('open.user', ['user' => $user]), $user->updated_at, '1.0', 'hourly');
            }

            foreach (Account::where('locked', false)->latest()->cursor() as $account) {
                $sitemap->add(route('open.account.index',
                    ['user' => $account->user, 'username' => $account->username, 'domain' => $account->domain]),
                    $account->updated_at, '0.5', 'hourly');
            }
        }

        return $sitemap->render('xml');
    }
}
