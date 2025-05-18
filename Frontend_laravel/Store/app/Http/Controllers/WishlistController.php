<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WishlistController extends Controller
{
    /**
     * Display wishlist
     */
    public function index()
    {
        if (!Session::has('is_logged_in') || !Session::get('is_logged_in')) {
            return redirect()->route('login')->with('error', 'Please login to access your wishlist');
        }

        $userId = Session::get('user.user_id');
        $apiBaseUrl = env('API_BASE_URL', 'http://127.0.0.1:8001/api');
        $products = [];
        
        try {
            // Get wishlist items from API
            $response = Http::get("{$apiBaseUrl}/wishlists/?user_id={$userId}");
            
            if ($response->successful()) {
                $wishlistItems = $response->json();
                
                // Fetch product details for each wishlist item
                foreach ($wishlistItems as $item) {
                    $productId = $item['product_id'];
                    $productResponse = Http::get("{$apiBaseUrl}/products/{$productId}");
                    
                    if ($productResponse->successful()) {
                        $products[] = $productResponse->json();
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Wishlist error: ' . $e->getMessage());
            // Continue with empty products array
        }

        return view('wishlist.index', ['products' => $products]);
    }

    /**
     * Add to wishlist
     */
    public function add(Request $request)
    {
        if (!Session::has('is_logged_in') || !Session::get('is_logged_in')) {
            return response()->json(['success' => false, 'message' => 'Please login to add items to your wishlist'], 401);
        }

        $userId = Session::get('user.user_id');
        $productId = $request->product_id;
        $apiBaseUrl = env('API_BASE_URL', 'http://127.0.0.1:8001/api');

        try {
            // Add to wishlist using API
            $response = Http::post("{$apiBaseUrl}/wishlists/", [
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            
            if ($response->successful()) {
                return response()->json(['success' => true, 'message' => 'Product added to wishlist']);
            } else {
                $errorMsg = $response->json()['detail'] ?? 'Failed to add product to wishlist';
                return response()->json(['success' => false, 'message' => $errorMsg], $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Add to wishlist error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to add product to wishlist'], 500);
        }
    }

    /**
     * Remove from wishlist
     */
    public function remove(Request $request, $productId)
    {
        if (!Session::has('is_logged_in') || !Session::get('is_logged_in')) {
            return back()->with('error', 'Please login to manage your wishlist');
        }

        $userId = Session::get('user.user_id');
        $apiBaseUrl = env('API_BASE_URL', 'http://127.0.0.1:8001/api');

        try {
            // Remove from wishlist using API
            $response = Http::delete("{$apiBaseUrl}/wishlists/{$userId}/{$productId}");
            
            if ($response->successful()) {
                return back()->with('success', 'Product removed from wishlist');
            } else {
                $errorMsg = $response->json()['detail'] ?? 'Failed to remove product from wishlist';
                return back()->with('error', $errorMsg);
            }
        } catch (\Exception $e) {
            Log::error('Remove from wishlist error: ' . $e->getMessage());
            return back()->with('error', 'Failed to remove product from wishlist');
        }
    }

    /**
     * Check if product is in wishlist
     */
    public function check(Request $request, $productId)
    {
        if (!Session::has('is_logged_in') || !Session::get('is_logged_in')) {
            return response()->json(['in_wishlist' => false]);
        }

        $userId = Session::get('user.user_id');
        $apiBaseUrl = env('API_BASE_URL', 'http://127.0.0.1:8001/api');
        
        try {
            // Check if product is in wishlist using API
            $response = Http::get("{$apiBaseUrl}/wishlists/{$userId}/{$productId}");
            
            return response()->json([
                'in_wishlist' => $response->successful()
            ]);
        } catch (\Exception $e) {
            Log::error('Check wishlist error: ' . $e->getMessage());
            return response()->json(['in_wishlist' => false]);
        }
    }
}
