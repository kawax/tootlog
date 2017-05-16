<?php

namespace App\Http\Controllers\Open;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\User;

use App\Repository\Status\StatusRepositoryInterface as StatusRepository;

class ArchiveController extends Controller
{
    /**
     * @var StatusRepository
     */
    protected $statusRepository;

    /**
     * AccountController constructor.
     *
     * @param StatusRepository $statusRepository
     */
    public function __construct(StatusRepository $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    public function __invoke(User $user)
    {
        $archives = $this->statusRepository->openArchives($user);

        return view('open.archives')->with(compact('user', 'archives'));
    }
}
