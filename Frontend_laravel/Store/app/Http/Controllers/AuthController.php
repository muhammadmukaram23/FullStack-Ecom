<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL', 'http://127.0.0.1:8001/api');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            // Call your API to authenticate
            $response = Http::post($this->apiBaseUrl . '/users/login', [
                'email' => $credentials['email'],
                'password' => $credentials['password']
            ]);

            if ($response->successful()) {
                $userData = $response->json();
                
                // Store user data in session
                Session::put('user', $userData);
                Session::put('is_logged_in', true);
                Session::put('user_id', $userData['user_id'] ?? null);
                
                // Initialize cart count
                $this->initializeCartCount($userData['user_id'] ?? null);
                
                return redirect()->intended('/');
            }
            
            // If login failed, get error message from API if available
            $errorMessage = 'The provided credentials do not match our records.';
            if ($response->json() && isset($response->json()['detail'])) {
                $errorMessage = $response->json()['detail'];
            }
            
            return back()->withErrors([
                'email' => $errorMessage,
            ]);
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Authentication service unavailable. Please try again later. Error: ' . $e->getMessage(),
            ]);
        }
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'age' => 'required|integer|min:18|max:120',
        ]);

        try {
            // Call your API to register the user
            $response = Http::post($this->apiBaseUrl . '/users/', [
                'user_name' => $validatedData['name'],
                'user_email' => $validatedData['email'],
                'user_password' => $validatedData['password'],
                'user_age' => $validatedData['age'],
            ]);

            if ($response->successful()) {
                $userData = $response->json();
                
                // Store user data in session
                Session::put('user', $userData);
                Session::put('is_logged_in', true);
                Session::put('user_id', $userData['user_id'] ?? null);
                
                // Initialize cart count for new user (likely 0 since they just registered)
                Session::put('cart_count', 0);
                
                return redirect('/');
            }
            
            // If registration failed, get detailed error message from API
            $errorMessage = 'Registration failed. Please try again.';
            if ($response->json() && isset($response->json()['detail'])) {
                $errorMessage = 'Registration failed: ' . $response->json()['detail'];
            }
            
            return back()->withErrors([
                'email' => $errorMessage,
            ])->withInput();
        } catch (\Exception $e) {
            // Add more detailed error handling
            return back()->withErrors([
                'email' => 'Registration service unavailable. Please try again later. Error: ' . $e->getMessage(),
            ])->withInput();
        }
    }

    public function logout(Request $request)
    {
        // Clear the user from the session
        Session::forget('user');
        Session::forget('is_logged_in');
        Session::forget('user_id');
        Session::forget('cart_count');
        
        Session::flush();
        
        return redirect('/');
    }

    /**
     * Helper method to initialize the cart count
     */
    private function initializeCartCount($userId)
    {
        if (!$userId) {
            Session::put('cart_count', 0);
            return;
        }
        
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
            \Log::error('Error initializing cart count: ' . $e->getMessage());
            Session::put('cart_count', 0);
        }
    }
} 