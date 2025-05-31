<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Regenerate CSRF token for the form
        Session::regenerateToken();
        return view('auth.Login');
    }

    public function login(Request $request)
    {
        Log::info('Login attempt', [
            'username' => $request->username,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'has_csrf_token' => $request->hasHeader('X-CSRF-TOKEN'),
            'session_id' => Session::getId()
        ]);

        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        Log::info('Credentials validated', $credentials);

        if (Auth::attempt($credentials)) {
            Log::info('Login successful', [
                'user' => Auth::user(),
                'session_id' => Session::getId()
            ]);

            // Regenerate session ID to prevent session fixation
            $request->session()->regenerate();

            // Set secure cookie parameters
            $cookie = Cookie::make(
                'XSRF-TOKEN',
                $request->session()->token(),
                120, // 2 hours
                '/',
                null,
                true, // secure
                false, // httpOnly
                false, // raw
                'None' // sameSite
            );

            $user = Auth::user();
            Log::info('User role', ['role' => $user->role]);

            $response = null;
            switch ($user->role) {
                case 'admin':
                    $response = redirect()->intended('/admin/dashboard');
                    break;
                case 'dinas':
                    $response = redirect()->intended('/dinas/laporan/masyarakat');
                    break;
                case 'pemerintahpusat':
                    $response = redirect()->intended('/pemerintahpusat/dashboard');
                    break;
                case 'masyarakat':
                    $response = redirect()->intended('/masyarakat/dashboard');
                    break;
                default:
                    $response = redirect()->intended('/');
            }

            return $response->withCookie($cookie);
        }

        Log::warning('Login failed', [
            'username' => $request->username,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Log::info('Logout attempt', [
            'user' => Auth::user(),
            'session_id' => Session::getId()
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
