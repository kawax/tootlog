<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserUpdateRequest;

class PreferencesController extends Controller
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        return view('prefs.index');
    }

    /**
     * @param  UserUpdateRequest  $request
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function update(UserUpdateRequest $request)
    {
        $user = $request->user();

        if ($user->email !== $request->email) {
            $user->email_verified_at = null;
        }

        $user->fill($request->only([
            'email',
            'theme',
            'special_key',
        ]))->save();

        return view('prefs.index');
    }
}
