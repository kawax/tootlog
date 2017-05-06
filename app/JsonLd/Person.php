<?php

namespace App\JsonLd;

use JsonLd\ContextTypes\AbstractContext;

class Person extends AbstractContext
{
    /**
     * Property structure
     *
     * @var array
     */
    protected $structure = [
        'name' => null,
        'image' => null,
        'description' => null,
        'url' => null,
    ];
}
