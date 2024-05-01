<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request, User $user): View
    {
        $statuses = $user->openStatuses($request->query('search'))->paginate();

        return view('open.user')->with(compact('user', 'statuses'));
    }
}
