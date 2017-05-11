<?php

namespace App\Http\Controllers\Open;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\User;

use App\Repository\Status\StatusRepositoryInterface as Status;

use OpenGraph;
use Twitter;

class UserController extends Controller
{
    public function index(User $user, Status $statusRepository)
    {
        $statuses = $statusRepository->openUserStatuses($user);

        $title = $user->name . '@' . config('app.name', 'tootlog');

        OpenGraph::setSiteName(config('app.name', 'tootlog'));
        OpenGraph::setDescription($title);
        OpenGraph::setTitle($title);
        OpenGraph::setUrl(route('open.user', [$user]));
        OpenGraph::addProperty('type', 'profile');

        Twitter::setTitle($title);
        Twitter::setType('summary');

        return view('open.user')->with(compact('user',  'statuses'));
    }
}
