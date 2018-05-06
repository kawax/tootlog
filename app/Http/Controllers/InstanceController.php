<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repository\Server\ServerRepositoryInterface as ServerRepository;

class InstanceController extends Controller
{
    /**
     * @param ServerRepository $repository
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function __invoke(ServerRepository $repository)
    {
        $instances = $repository->instanceList();

        return view('instance.list')->with(compact('instances'));
    }
}
