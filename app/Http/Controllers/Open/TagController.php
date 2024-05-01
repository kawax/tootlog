<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        $tags = $user->tags()->take(100);

        return view('tags.index')->with(compact('user', 'tags'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user, Tag $tag)
    {
        $statuses = $user->openTagStatuses($tag, $request->query('search'))->simplePaginate();

        return view('tags.show')->with(compact('user', 'tag', 'statuses'));
    }
}
