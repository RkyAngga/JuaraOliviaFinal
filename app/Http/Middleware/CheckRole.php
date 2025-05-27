<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        Log::info('Checking role', [
            'user' => $request->user(),
            'required_roles' => $roles,
            'current_url' => $request->url(),
            'method' => $request->method()
        ]);

        if (!$request->user()) {
            Log::warning('No authenticated user');
            return redirect()->route('login.form')->with('message', 'Silakan login terlebih dahulu.');
        }

        $userRole = $request->user()->role;
        Log::info('User role found', ['role' => $userRole]);

        if (!in_array($userRole, $roles)) {
            Log::warning('User role not authorized', [
                'user_role' => $userRole,
                'required_roles' => $roles,
                'user_id' => $request->user()->id
            ]);
            
            // Redirect based on user's role
            switch ($userRole) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'dinas':
                    return redirect()->route('dinas.dashboard');
                case 'pemerintah_pusat':
                    return redirect()->route('pemerintah.dashboard');
                case 'masyarakat':
                    return redirect()->route('masyarakat.dashboard');
                default:
                    return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }
        }

        Log::info('Role check passed', [
            'user_role' => $userRole,
            'route_name' => $request->route()->getName()
        ]);

        return $next($request);
    }
} 