<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAuthentication
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
        // Check if admin is logged in via session
        if (!Session::has('admin_logged_in') || !Session::get('admin_logged_in')) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            }
            
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
} 