<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Contracts\View\View;

class InstanceController extends Controller
{
    public function __invoke(): View
    {
        $instances = Server::withCount('accounts')
            ->orderByDesc('accounts_count')
            ->paginate(20);

        return view('instance.list')->with(compact('instances'));
    }
}
