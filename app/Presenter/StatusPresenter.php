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

        return Context::create(SocialMediaPosting::class, [
            'author'        => [
                'name'  => $status->name,
                'image' => $status->account->avatar,
                'url'   => $status->account->url,
            ],
            'articleBody'   => $status->content,
            'headline'      => $status->spoiler_text ?: ' ',
            'datePublished' => $status->created_at,
            'url'           => $status->url,
            'image'         => $status->account->avatar,
        ]);
    }
}
