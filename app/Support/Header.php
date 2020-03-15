<?php

namespace App\Support;

use GuzzleHttp\Psr7;
use Illuminate\Support\Arr;
use Psr\Http\Message\ResponseInterface;

class Header
{
    /**
     * @param  ResponseInterface  $response
     *
     * @return string
     */
    public static function since(ResponseInterface $response): string
    {
        if (! $response->hasHeader('Link')) {
            return '';
        }

        $link = Psr7\parse_header($response->getHeader('Link'));

        if (empty($link)) {
            return '';
        }

        $link = Arr::first($link, fn ($value) => data_get($value, 'rel') === 'prev');

        $url = head($link);
        $url = str_replace(['<', '>'], '', $url);

        parse_str(parse_url($url, PHP_URL_QUERY), $query);

        return Arr::get($query, 'since_id', Arr::get($query, 'min_id', ''));
    }
}
