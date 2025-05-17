<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL', 'http://127.0.0.1:8001/api');
        $this->middleware('api.auth');
    }

    public function index()
    {
        try {
            // Get user's active cart
            $userId = Session::get('user_id');
            $response = Http::get($this->apiBaseUrl . '/carts/user/' . $userId);
            
            if ($response->failed()) {
                Session::put('cart_count', 0);
                return view('cart.index', ['items' => [], 'total' => 0]);
            }
            
            $cart = $response->json();
            
            // Get cart items with product details including images
            $itemsResponse = Http::get($this->apiBaseUrl . '/carts/' . $cart['cart_id'] . '/items');
            $items = $itemsResponse->json();
            
            // Log the response for debugging
            \Log::info('Cart items response', ['items' => $items]);
            
            // If product images aren't included in the response, we need to fetch them for each product
            if (count($items) > 0 && !isset($items[0]['product']['images'])) {
                \Log::info('Product images not included in cart items, fetching them separately');
                
                foreach ($items as $key => $item) {
                    $productId = $item['product']['product_id'];
                    $productResponse = Http::get($this->apiBaseUrl . '/products/' . $productId);
                    
                    if ($productResponse->successful()) {
                        $fullProduct = $productResponse->json();
                        $items[$key]['product'] = $fullProduct;
                        \Log::info('Fetched product details', ['product_id' => $productId, 'has_images' => isset($fullProduct['images'])]);
                    }
                }
            }
            
            // Calculate total
            $total = 0;
            foreach ($items as $item) {
                $total += $item['product']['product_price'] * $item['quantity'];
            }
            
            // Update the cart count in the session
            Session::put('cart_count', count($items));
            
            return view('cart.index', compact('items', 'cart', 'total'));
        } catch (\Exception $e) {
            \Log::error('Error fetching cart: ' . $e->getMessage());
            Session::put('cart_count', 0);
            return view('cart.index', ['items' => [], 'total' => 0, 'error' => 'Unable to fetch cart. ' . $e->getMessage()]);
        }
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            // First, get or create user's cart
            $userId = Session::get('user_id');
            $response = Http::get($this->apiBaseUrl . '/carts/user/' . $userId);
            
            if ($response->failed()) {
                // Create a new cart
                $cartResponse = Http::post($this->apiBaseUrl . '/carts', [
                    'user_id' => $userId
                ]);
                $cart = $cartResponse->json();
            } else {
                $cart = $response->json();
            }
            
            // Add item to cart
            Http::post($this->apiBaseUrl . '/carts/' . $cart['cart_id'] . '/items', [
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
            
            // Update cart count in session
            $this->updateCartCount($userId);
            
            return redirect()->route('cart.index')->with('success', 'Product added to cart successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add product to cart: ' . $e->getMessage());
        }
    }

    public function updateCartItem(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            Http::put($this->apiBaseUrl . '/carts/items/' . $itemId, [
                'quantity' => $request->quantity
            ]);
            
            // Update cart count in session
            $this->updateCartCount(Session::get('user_id'));
            
            return redirect()->route('cart.index')->with('success', 'Cart updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update cart item: ' . $e->getMessage());
        }
    }

    public function removeCartItem($itemId)
    {
        try {
            Http::delete($this->apiBaseUrl . '/carts/items/' . $itemId);
            
            // Update cart count in session
            $this->updateCartCount(Session::get('user_id'));
            
            return redirect()->route('cart.index')->with('success', 'Item removed from cart');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to remove item from cart: ' . $e->getMessage());
        }
    }

    /**
     * Helper method to update the cart count in the session
     */
    private function updateCartCount($userId)
    {
        try {
            $response = Http::get($this->apiBaseUrl . '/carts/user/' . $userId);
            
            if ($response->failed()) {
                Session::put('cart_count', 0);
                return;
            }
            
            $cart = $response->json();
            $itemsResponse = Http::get($this->apiBaseUrl . '/carts/' . $cart['cart_id'] . '/items');
            
            if ($itemsResponse->successful()) {
                $items = $itemsResponse->json();
                Session::put('cart_count', count($items));
            } else {
                Session::put('cart_count', 0);
            }
        } catch (\Exception $e) {
            \Log::error('Error updating cart count: ' . $e->getMessage());
            Session::put('cart_count', 0);
        }
    }
} 