<?php

namespace App\JsonLd;

use JsonLd\ContextTypes\AbstractContext;

class SocialMediaPosting extends AbstractContext
{
    /**
     * Property structure
     *
     * @var array
     */
    protected $structure = [
        'author' => \JsonLd\ContextTypes\Person::class,
        'articleBody' => null,
        'headline' => null,
        'datePublished' => null,
        'url' => null,
    ];
}
