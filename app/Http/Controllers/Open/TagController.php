<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\User;
use App\Repository\Status\StatusRepository as Status;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(User $user)
    {
        $tags = $user->tags()->take(100);

        return view('tags.index')->with(compact('user', 'tags'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Status  $statusRepository
     * @param  User  $user
     * @param  Tag  $tag
     * @return Application|Factory|View
     */
    public function show(Status $statusRepository, User $user, Tag $tag)
    {
        $statuses = $statusRepository->openUserTagStatus($user, $tag);

        return view('tags.show')->with(compact('user', 'tag', 'statuses'));
    }
}
