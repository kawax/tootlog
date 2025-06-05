<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Symfony\Component\HttpFoundation\Response;

class SitemapController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $sitemap = Sitemap::create();

        $sitemap->add(
            Url::create(url('/'))
                ->setLastModificationDate(now())
                ->setPriority(0.2)
                ->setChangeFrequency('weekly')
        );

        foreach (User::latest()->cursor() as $user) {
            $sitemap->add(
                Url::create(route('open.user', ['user' => $user]))
                    ->setLastModificationDate($user->updated_at)
                    ->setPriority(1.0)
                    ->setChangeFrequency('hourly')
            );
        }

        $accounts = Account::where('locked', false)
            ->latest()
            ->cursor();

        foreach ($accounts as $account) {
            $sitemap->add(
                Url::create(route('open.account.index', [
                    'user' => $account->user,
                    'username' => $account->username,
                    'domain' => $account->domain,
                ]))->setLastModificationDate($account->updated_at)
                    ->setPriority(0.5)
                    ->setChangeFrequency('hourly'));
        }

        return $sitemap->toResponse($request);
    }
}
