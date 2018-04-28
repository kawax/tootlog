<?php

use JSila\Twemoji\Twemoji;

if (!function_exists('twemoji')) {

    /**
     * @param string $text
     *
     * @return string
     */
    function twemoji($text)
    {
        try {
            return (new Twemoji)->parseText($text);
        } catch (\Exception $e) {
            return $text;
        }
    }
}
