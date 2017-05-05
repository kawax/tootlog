<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class TagComposer
{
    protected $statusRepository;

    public function __construct()
    {
        //
    }

    public function compose(View $view)
    {
        if (!is_null(request()->user)) {
            $view->with('tags', request()->user->tags()->take(10));
        }
    }
}
