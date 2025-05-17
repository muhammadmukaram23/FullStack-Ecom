<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL', 'http://127.0.0.1:8001/api');
    }

    public function home()
    {
        try {
            // Get products for homepage
            $response = Http::get($this->apiBaseUrl . '/products?limit=8');
            $products = $response->json();
            
            // Get categories for homepage
            $categoriesResponse = Http::get($this->apiBaseUrl . '/categories');
            $categories = $categoriesResponse->json();
            
            // Update cart count if user is logged in
            $this->updateCartCount();
            
            return view('pages.home', compact('products', 'categories'));
        } catch (\Exception $e) {
            return view('pages.home', ['products' => [], 'categories' => [], 'error' => 'Unable to fetch data. ' . $e->getMessage()]);
        }
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function submitContact(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10'
        ]);

        try {
            // Submit contact form data to the API
            $response = Http::post($this->apiBaseUrl . '/contacts', [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'subject' => $validatedData['subject'],
                'message' => $validatedData['message']
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Your message has been sent successfully. We will get back to you soon!');
            }
            
            return back()->withErrors(['message' => 'Failed to send message. Please try again.'])->withInput();
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Service unavailable. Please try again later. Error: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Update the cart count in the session
     */
    private function updateCartCount()
    {
        if (!Session::has('is_logged_in') || !Session::get('is_logged_in') || !Session::has('user_id')) {
            Session::put('cart_count', 0);
            return;
        }
        
        try {
            $userId = Session::get('user_id');
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
                \Log::info('Cart count updated in PageController', ['count' => count($items)]);
            } else {
                Session::put('cart_count', 0);
            }
        } catch (\Exception $e) {
            \Log::error('Error updating cart count: ' . $e->getMessage());
            if (!Session::has('cart_count')) {
                Session::put('cart_count', 0);
            }
        }
    }
} 