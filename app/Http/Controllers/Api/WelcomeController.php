<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * welcomeページ用に公開可能な投稿をランダムに返すAPI.
     */
    public function __invoke(Request $request)
    {
        return Status::whereHas('account', function ($query) {
            $query->where('locked', false);
        })
            ->select(['content', 'created_at'])
            ->latest()
            ->limit(1000)
            ->get()
            ->random(100)
            ->reject(fn ($item) => empty($item->content))
            ->map(fn ($item) => str($item->content)->stripTags()->limit(200)->toString())
            ->toPrettyJson(JSON_UNESCAPED_UNICODE);
    }
}
