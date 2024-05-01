<?php

namespace App\Http\Controllers;

use App\Models\Server;

class InstanceController extends Controller
{
    public function __invoke()
    {
        $instances = Server::withCount('accounts')
            ->orderByDesc('accounts_count')
            ->paginate(20);

        return view('instance.list')->with(compact('instances'));
    }
}
