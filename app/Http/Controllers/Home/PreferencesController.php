<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserUpdateRequest;

class PreferencesController extends Controller
{
    public function index()
    {
        return view('prefs.index');
    }

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
