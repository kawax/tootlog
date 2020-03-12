<?php

namespace App\View\Composers;

use Illuminate\View\View;

class TagComposer
{
    public function __construct()
    {
        //
    }

    public function compose(View $view)
    {
        if (! is_null(request()->user)) {
            $view->with('tags', request()->user->tags()->take(10));
        }
    }
}
