<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

use App\Repository\Status\StatusRepositoryInterface as Status;
use App\Model\User;

class RecentComposer
{
    protected $statusRepository;

    public function __construct(Status $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    public function compose(View $view)
    {
        if (!is_null(request()->user)) {
            $view->with('recents', $this->statusRepository->openRecents(request()->user));
        }
    }
}
