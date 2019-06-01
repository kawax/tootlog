<?php

namespace App\Http\Controllers\Open;

use Twitter;
use OpenGraph;
use App\Model\User;
use App\Http\Controllers\Controller;
use App\Repository\Status\StatusRepository as Status;

class UserController extends Controller
{
    public function index(User $user, Status $statusRepository)
    {
        $statuses = $statusRepository->openUserStatuses($user);

        $title = $user->name.'@'.config('app.name', 'tootlog');

        OpenGraph::setSiteName(config('app.name', 'tootlog'));
        OpenGraph::setDescription($title);
        OpenGraph::setTitle($title);
        OpenGraph::setUrl(route('open.user', [$user]));
        OpenGraph::addProperty('type', 'profile');

        Twitter::setTitle($title);
        Twitter::setType('summary');

        return view('open.user')->with(compact('user', 'statuses'));
    }
}
