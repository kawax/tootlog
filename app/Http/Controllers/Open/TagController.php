<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Model\Tag;
use App\Model\User;
use App\Repository\Status\StatusRepository as Status;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Status $statusRepository, User $user, Tag $tag)
    {
        $statuses = $statusRepository->openUserTagStatus($user, $tag);

        return view('tags.show')->with(compact('user', 'tag', 'statuses'));
    }
}
