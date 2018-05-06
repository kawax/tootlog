<?php

namespace App\Repository\Server;

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
        } else {
            $client_name = config('app.name');
            $redirect_uris = config('services.mastodon.redirect');
            $scopes = implode(' ', config('services.mastodon.scope'));

            $info = Mastodon::domain($domain)
                            ->createApp($client_name, $redirect_uris, $scopes);

            $info['app_id'] = $info['id'];
            $info['domain'] = $domain;

            $server = $this->create($info);
        }

        return $server->toArray();
    }

    /**
     * @param int $page
     *
     * @return mixed
     */
    public function instanceList($page)
    {
        return Server::withCount('accounts')
                     ->orderBy('accounts_count', 'DESC')
                     ->paginate($page);
    }
}
