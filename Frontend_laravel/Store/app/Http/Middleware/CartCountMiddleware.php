<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CartCountMiddleware
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
        // Only update cart count if user is logged in
        if (Session::has('is_logged_in') && Session::get('is_logged_in') && Session::has('user_id')) {
            $this->updateCartCount(Session::get('user_id'));
        } else {
            // If user is not logged in, set cart count to 0
            Session::put('cart_count', 0);
        }

        return $next($request);
    }

    /**
     * Update the cart count in the session
     */
    private function updateCartCount($userId)
    {
        try {
            $apiBaseUrl = env('API_BASE_URL', 'http://127.0.0.1:8001/api');
            $response = Http::get($apiBaseUrl . '/carts/user/' . $userId);
            
            if ($response->failed()) {
                Session::put('cart_count', 0);
                return;
            }
            
            $cart = $response->json();
            $itemsResponse = Http::get($apiBaseUrl . '/carts/' . $cart['cart_id'] . '/items');
            
            if ($itemsResponse->successful()) {
                $items = $itemsResponse->json();
                Session::put('cart_count', count($items));
            } else {
                Session::put('cart_count', 0);
            }
        } catch (\Exception $e) {
            // Log error but don't crash the application
            \Log::error('Error updating cart count in middleware: ' . $e->getMessage());
            if (!Session::has('cart_count')) {
                Session::put('cart_count', 0);
            }
        }
    }
} 