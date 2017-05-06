<?php

namespace App\Presenter;

use JsonLd\Context;
use App\JsonLd\Person;
use McCool\LaravelAutoPresenter\BasePresenter;

class AccountPresenter extends BasePresenter
{
    /**
     * Create JSON-LD object.
     *
     * @return \JsonLd\Context|string
     */
    public function jsonLd()
    {
        $account = $this->wrappedObject;

        return Context::create(Person::class, [
            'name'        => $account->name,
            'image'       => $account->avatar,
            'description' => $account->note,
            'url'         => $account->url,
        ]);
    }
}
