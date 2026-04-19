<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect('/admin');
        }

        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $throttleKey = Str::lower($request->email) . '|admin|' . $request->ip();
        $attempts = RateLimiter::attempts($throttleKey);

        // Check rate limit
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()
                ->withInput($request->only('email'))
                ->with('throttle', "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.");
        }

        // Attempt login
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            if ($user->role !== 'admin') {
                Auth::logout();
                RateLimiter::hit($throttleKey, 60);
                return back()
                    ->withInput($request->only('email'))
                    ->with('error', 'Akun ini tidak memiliki akses admin.');
            }

            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }

        RateLimiter::hit($throttleKey, 60);
        $attemptsAfter = RateLimiter::attempts($throttleKey);

        $response = back()->withInput($request->only('email'))->withErrors([
            'email' => 'Email atau kata sandi salah.',
        ]);

        if ($attemptsAfter >= 3) {
            $response = $response->with('throttle', "Peringatan: {$attemptsAfter} percobaan gagal. Akun akan dikunci setelah 5 percobaan.");
        }

        return $response;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
