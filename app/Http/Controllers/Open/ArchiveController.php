<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\User;

class ArchiveController extends Controller
{
    public function __invoke(User $user)
    {
        $archives = $user->openArchives();

        return view('open.archives')->with(compact('user', 'archives'));
    }
}
