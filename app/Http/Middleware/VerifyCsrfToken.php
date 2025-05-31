<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Closure;
use Illuminate\Session\TokenMismatchException;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*',
        'sanctum/csrf-cookie',
        'login',
        'register',
        'logout'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Ensure session is started and CSRF token exists
        if (!$request->session()->has('_token')) {
            $request->session()->regenerateToken();
        }

        // Check if it's a mobile browser
        $userAgent = $request->header('User-Agent');
        $isMobile = strpos($userAgent, 'Mobile') !== false ||
                   strpos($userAgent, 'Android') !== false ||
                   strpos($userAgent, 'iPhone') !== false;

        // For mobile browsers or pre-authentication requests
        if ($isMobile || !auth()->check()) {
            // Add the token to the request if it's a POST request
            if ($request->isMethod('POST')) {
                $request->headers->set('X-CSRF-TOKEN', csrf_token());
            }
        }

        try {
            return parent::handle($request, $next);
        } catch (TokenMismatchException $e) {
            if ($request->isMethod('POST')) {
                // Regenerate CSRF token
                $request->session()->regenerateToken();

                // If it's a mobile browser or pre-authentication, allow the request after regenerating token
                if ($isMobile || !auth()->check()) {
                    $request->headers->set('X-CSRF-TOKEN', csrf_token());
                    return $next($request);
                }
            }
            throw $e;
        }
    }
}
