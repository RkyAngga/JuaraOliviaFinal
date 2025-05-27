<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.Login');
    }

    public function login(Request $request)
    {
        Log::info('Login attempt', ['username' => $request->username]);
        
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        Log::info('Credentials validated', $credentials);

        if (Auth::attempt($credentials)) {
            Log::info('Login successful', ['user' => Auth::user()]);
            $request->session()->regenerate();
            
            $user = Auth::user();
            Log::info('User role', ['role' => $user->role]);
            
            switch ($user->role) {
                case 'admin':
                    return redirect()->intended('/admin/dashboard');
                case 'dinas':
                    return redirect()->intended('/dinas/laporan/masyarakat');
                case 'pemerintahpusat':
                    return redirect()->intended('/pemerintahpusat/dashboard');
                case 'masyarakat':
                    return redirect()->intended('/masyarakat/dashboard');
                default:
                    return redirect()->intended('/');
            }
        }

        Log::warning('Login failed', ['username' => $request->username]);
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home');
    }
}
