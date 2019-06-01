<?php

namespace App\Http\Controllers;

use App\Repository\Server\ServerRepository;

class InstanceController extends Controller
{
    /**
     * @param  ServerRepository  $repository
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function __invoke(ServerRepository $repository)
    {
        $instances = $repository->instanceList();

        return view('instance.list')->with(compact('instances'));
    }
}
