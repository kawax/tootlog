<?php

namespace App\Presenter;

use JsonLd\Context;
use App\JsonLd\SocialMediaPosting;
use McCool\LaravelAutoPresenter\BasePresenter;

class StatusPresenter extends BasePresenter
{
    /**
     * Create JSON-LD object.
     *
     * @return \JsonLd\Context|string
     */
    public function jsonLd()
    {
        $status = $this->wrappedObject;

        $url = route('open.account.show',
            [
                $status->account->user,
                $status->account->username,
                $status->account->domain,
                $status->status_id,
            ]
        );

        return Context::create(SocialMediaPosting::class, [
            'author'        => [
                'name'  => $status->name,
                'image' => $status->account->avatar,
                'url'   => $status->account->url,
            ],
            'articleBody'   => $status->content,
            'headline'      => $status->spoiler_text ?: $status->content,
            'datePublished' => $status->created_at,
            'url'           => $url,
            'sameAs'        => $status->url,
            'image'         => $status->account->avatar,
        ]);
    }
}
