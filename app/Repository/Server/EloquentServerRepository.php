<?php

namespace App\Repository\Server;

use Illuminate\Support\Str;

use App\Model\Server;
use Mastodon;

class EloquentServerRepository implements ServerRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(string $domain)
    {
        return Server::where('domain', '=', $domain)->first();
    }

    /**
     * @inheritDoc
     */
    public function all()
    {
        return Server::all();
    }

    /**
     * @inheritDoc
     */
    public function has(string $domain): bool
    {
        return Server::where('domain', '=', $domain)->exists();
    }

    /**
     * @inheritDoc
     */
    public function create(array $data)
    {
        return Server::create($data);
    }

    /**
     * @inheritDoc
     */
    public function firstOrCreate(string $domain): array
    {
        $domain = trim($domain, "/\t\n\r\0\x0B");

        if ($this->has($domain)) {
            $server = $this->get($domain);

            //redirect_uriが旧ドメインの場合はAppを作り直す。
            if (Str::start($server->redirect_uri, url('/'))) {
                return $server->toArray();
            }
        }

        $client_name = config('app.name');
        $redirect_uris = config('services.mastodon.redirect');
        $scopes = implode(' ', config('services.mastodon.scope'));

        $info = Mastodon::domain($domain)
                        ->createApp($client_name, $redirect_uris, $scopes, config('app.url'));

        $info['app_id'] = $info['id'];
        $info['domain'] = $domain;

        $server = Server::updateOrCreate(
            ['domain' => $domain],
            $info
        );

        return $server->toArray();
    }

    /**
     * @param int $page
     *
     * @return mixed
     */
    public function instanceList(int $page = 20)
    {
        return Server::withCount('accounts')
                     ->orderBy('accounts_count', 'DESC')
                     ->paginate($page);
    }
}
