<?php

namespace App\Http\Controllers\Open;

use App\Model\User;
use App\Model\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repository\Status\StatusRepositoryInterface as StatusRepository;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(User $user)
    {
        $tags = $user->tags()->take(100);

        return view('tags.index')->with(compact('user', 'tags'));
    }

    /**
     * Display the specified resource.
     *
     * @param  StatusRepository $statusRepository
     * @param  \App\Model\user  $user
     * @param  \App\Model\Tag   $tag
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(StatusRepository $statusRepository, User $user, Tag $tag)
    {
        $statuses = $statusRepository->openUserTagStatus($user, $tag);

        return view('tags.show')->with(compact('user', 'tag', 'statuses'));
    }
}
