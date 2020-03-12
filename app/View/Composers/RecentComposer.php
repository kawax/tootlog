<?php

namespace App\View\Composers;

use App\Repository\Status\StatusRepository as Status;
use Illuminate\View\View;

class RecentComposer
{
    protected $statusRepository;

    public function __construct(Status $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    public function compose(View $view)
    {
        if (! is_null(request()->user)) {
            $view->with('recents', $this->statusRepository->openRecents(request()->user));
        }
    }
}
