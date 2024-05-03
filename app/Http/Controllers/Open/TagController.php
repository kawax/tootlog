<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(User $user): View
    {
        $tags = $user->tags()->take(100);

        return view('tags.index')->with(compact('user', 'tags'));
    }

    public function show(Request $request, User $user, Tag $tag): View
    {
        $statuses = $user->openTagStatuses($tag, $request->query('search'))->simplePaginate();

        return view('tags.show')->with(compact('user', 'tag', 'statuses'));
    }
}
