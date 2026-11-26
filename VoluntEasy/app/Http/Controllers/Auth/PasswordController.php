<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

/**
 * "Forgot your password?" flow: send a reset link, then set a new password.
 */
class PasswordController extends Controller
{
    public function getEmail(): View
    {
        return view('auth.password');
    }

    public function postEmail(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', trans($status))
            : back()->withErrors(['email' => trans($status)])->withInput($request->only('email'));
    }

    public function getReset(string $token): View
    {
        return view('auth.reset', ['token' => $token]);
    }

    public function postReset(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password): void {
                // User::setPasswordAttribute does not hash, so hash here.
                $user->password = bcrypt($password);
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect('auth/login')->with('status', trans($status))
            : back()->withErrors(['email' => trans($status)])->withInput($request->only('email'));
    }
}
