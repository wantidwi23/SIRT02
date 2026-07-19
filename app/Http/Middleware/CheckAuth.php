<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
    use Illuminate\Support\Facades\Auth;

class CheckAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated OR HeadOfFamily is logged in via session
        if (Auth::check() || session('head_of_family_id')) {
            return $next($request);
        }

        return redirect('/login');
    }
}
