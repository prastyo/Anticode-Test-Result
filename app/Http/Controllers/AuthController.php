<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages/auth/login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
                'login'    => 'required',
                'password' => 'required',
        ]);

        // Check if the 'login' input is a valid email. If valid, set $login_type to 'email', otherwise set it to 'username'.
        $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL )  ? 'email' : 'username';

        // Merge the determined $login_type into the request, replacing the 'login' field with either 'email' or 'username'.
        $request->merge([
            $login_type => $request->input('login')
        ]);

        // Attempt to authenticate the user with the login type (email or username) and password. 
        // If authentication is successful, redirect the user to the intended page (or the dashboard by default).
        if (Auth::attempt($request->only($login_type, 'password'))) {
            return redirect()->intended('dashboard');
        }

        return redirect()->back()
            ->withInput()
            ->withErrors([
                'login' => __('site.login_failed'),
            ]);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();

        return redirect('/');
    }

    public function forgotPasswordForm()
    {
        return view('pages.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Send email
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function resetForm($token)
    {
        return view('pages.auth.reset-password', ['token' => $token]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token'     => 'required',
            'email'     => 'required|email',
            'password'  => 'required|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    public function register()
    {
        return view('pages.auth.register');
    }
}