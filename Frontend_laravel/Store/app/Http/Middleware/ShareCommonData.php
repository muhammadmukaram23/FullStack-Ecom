<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;

class ShareCommonData
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
        // Fetch categories from API
        try {
            $apiBaseUrl = env('API_BASE_URL', 'http://127.0.0.1:8001/api');
            $categoriesResponse = Http::get($apiBaseUrl . '/categories/');
            
            if ($categoriesResponse->successful()) {
                $categories = $categoriesResponse->json();
                // Share categories with all views
                View::share('navCategories', $categories);
            }
        } catch (\Exception $e) {
            // Silently fail - don't want the app to crash if categories can't be fetched
            View::share('navCategories', []);
        }

        return $next($request);
    }
} 