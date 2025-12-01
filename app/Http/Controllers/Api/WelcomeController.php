<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * welcomeページ用に公開可能な投稿をランダムに返すAPI.
     *
     * 直接実行すると時間がかかりすぎるので`welcome:cache`コマンドで毎日キャッシュしておき、
     * ここではキャッシュを返すだけにする。
     */
    public function __invoke(Request $request)
    {
        if (cache()->has('welcome_statuses')) {
            return cache()->get('welcome_statuses');
        } else {
            return Inspiring::quotes()->toJson();
        }
    }
}
