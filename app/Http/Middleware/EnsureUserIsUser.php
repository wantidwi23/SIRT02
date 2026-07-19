<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow regular user access
        if (Auth::check() && Auth::user()->role === 'user') {
            return $next($request);
        }

        // Allow admin access to chatbot
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Allow HeadOfFamily access via session
        if (session('head_of_family_id')) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
