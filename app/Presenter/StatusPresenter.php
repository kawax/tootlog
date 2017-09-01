<?php

namespace App\Presenter;

use JsonLd\Context;
use App\JsonLd\SocialMediaPosting;

trait StatusPresenter
{
    /**
     * Create JSON-LD object.
     *
     * @return \JsonLd\Context|string
     */
    public function jsonLd()
    {
        $url = route('open.account.show',
            [
                $this->account->user,
                $this->account->username,
                $this->account->domain,
                $this->status_id,
            ]
        );

        return Context::create(SocialMediaPosting::class, [
            'author'        => [
                'name'  => $this->name,
                'image' => $this->account->avatar,
                'url'   => $this->account->url,
            ],
            'articleBody'   => $this->content,
            'headline'      => $this->spoiler_text ?: $this->content,
            'datePublished' => $this->created_at,
            'url'           => $url,
            //            'sameAs'        => $this->url,
            'image'         => $this->account->avatar,
        ]);
    }
}
