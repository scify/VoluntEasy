<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Interfaces\ConfigurationInterface;

/**
 * Log in and log out. (Users are created by administrators, so there is
 * no public registration.)
 */
class AuthController extends Controller
{
    public function __construct(private readonly ConfigurationInterface $configuration) {}

    public function getLogin(): View
    {
        // Each deployment can show its own logos under the login form.
        $footerLogoPath = $this->configuration->getViewsPath().'._login_footer';

        return view('auth/login', compact('footerLogoPath'));
    }

    public function postLogin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth/login.failed'),
            ])->redirectTo(url('auth/login'));
        }

        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    public function getLogout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
