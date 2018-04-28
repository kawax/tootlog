<?php

if (!function_exists('twemoji')) {

    /**
     * Unicode絵文字をTwemojiに変換。
     * jsila/emoji-images-phpはなんか違ったのでいいのが見つかるまでは何もしないヘルパー
     *
     * @param string $text
     *
     * @return string
     */
    function twemoji($text)
    {
        return $text;
    }
}
