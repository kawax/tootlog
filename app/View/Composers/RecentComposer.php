<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Request;
use Illuminate\View\View;

class RecentComposer
{
    public function compose(View $view): void
    {
        if (Request::route()->hasParameter('user')) {
            $view->with('recents', request()->route('user')->openRecents());
        }
    }
}
