<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class UserController extends Controller
{
    public function profile(): View
    {
        /** @var User $user */
        $user = Auth::user();

        return view('users.profile', compact('user'));
    }
    public function edit(): View
    {
        /** @var User $user */
        $user = Auth::user();

        return view('users.edit', compact('user'));
    }
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $user->update($request->validated());

        return redirect()->route('web.users.profile')->with('success', 'Profile updated successfully.');
    }

}
