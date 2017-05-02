<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\User\UserUpdateRequest;

class PreferencesController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = $request->user();

        return view('prefs.index')->with(compact('user'));
    }

    /**
     * @param UserUpdateRequest $request
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function update(UserUpdateRequest $request)
    {
        $user = $request->user();

        $user->update([
            'email' => $request->input('email'),
        ]);

        return view('prefs.index')->with(compact('user'));
    }
}
