<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\User\UserUpdateRequest;

class PreferencesController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        return view('prefs.index');
    }

    /**
     * @param UserUpdateRequest $request
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function update(UserUpdateRequest $request)
    {
        $user = $request->user();

        $user->update($request->only([
            'email',
            'theme',
            'special_key',
        ]));

        return view('prefs.index');
    }
}
