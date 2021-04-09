<?php

namespace App\Http\Controllers;

use App\Repository\Server\ServerRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class InstanceController extends Controller
{
    /**
     * @param  ServerRepository  $repository
     *
     * @return Application|Factory|View
     */
    public function __invoke(ServerRepository $repository)
    {
        $instances = $repository->instanceList();

        return view('instance.list')->with(compact('instances'));
    }
}
