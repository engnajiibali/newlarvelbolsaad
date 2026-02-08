<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in and isadmin = 1s
        if (Auth::check() && Auth::user()->isAdmin == 1) {
            return $next($request);
        }

        // Optional: redirect non-admin users to dashboard
        return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page.');
        
        // Or abort 403
        // abort(403, 'Unauthorized action.');
    }
}
