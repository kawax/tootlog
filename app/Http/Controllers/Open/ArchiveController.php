<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;

class ArchiveController extends Controller
{
    public function __invoke(User $user): View
    {
        $archives = $user->openArchives();

        return view('open.archives')->with(compact('user', 'archives'));
    }
}
