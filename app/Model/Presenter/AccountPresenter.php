<?php

namespace App\Model\Presenter;

use App\JsonLd\Person;
use JsonLd\Context;

trait AccountPresenter
{
    /**
     * Create JSON-LD object.
     *
     * @return \JsonLd\Context|string
     */
    public function jsonLd()
    {
        $url = route('open.account.index', [
            $this->user,
            $this->username,
            $this->domain,
        ]);

        return Context::create(Person::class, [
            'name'        => e($this->name),
            'image'       => $this->avatar,
            'description' => e($this->note),
            'url'         => $url,
            //            'sameAs'      => $this->url,
        ]);
    }

    /**
     * @return string
     */
    public function getFaviconAttribute(): string
    {
        return $this->server->domain.'/'.
            data_get(config('tootlog.favicon'), $this->server->domain, 'favicon.ico');
    }
}
