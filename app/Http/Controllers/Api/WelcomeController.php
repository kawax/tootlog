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
        return Status::query()
            ->join('accounts', 'statuses.account_id', '=', 'accounts.id')
            ->where('accounts.locked', false)
            ->whereNotNull('statuses.content')
            ->where('statuses.content', '!=', '')
            ->select(['statuses.content'])
            ->inRandomOrder()
            ->limit(100)
            ->get()
            ->map(fn ($item) => str($item->content)->stripTags()->limit(200)->toString())
            ->toPrettyJson(JSON_UNESCAPED_UNICODE);
    }
}
