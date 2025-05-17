<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class APIAuthentication
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
        // Check if user is logged in via session
        if (!Session::has('is_logged_in') || !Session::get('is_logged_in')) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            }
            
            return redirect()->route('login');
        }

        return $next($request);
    }
} 