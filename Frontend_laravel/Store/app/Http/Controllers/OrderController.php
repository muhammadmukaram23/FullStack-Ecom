<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL', 'http://localhost:8001/api');
        $this->middleware('api.auth');
    }

    public function index()
    {
        try {
            $userId = Session::get('user_id');
            $response = Http::get($this->apiBaseUrl . '/orders/user/' . $userId);
            $orders = $response->json();
            
            // Calculate order totals if not set
            foreach ($orders as $key => $order) {
                // Skip if total_amount is already set and > 0
                if (isset($order['total_amount']) && $order['total_amount'] > 0) {
                    continue;
                }
                
                // Fetch cart information to calculate total
                if (isset($order['cart_id'])) {
                    $itemsResponse = Http::get($this->apiBaseUrl . '/carts/' . $order['cart_id'] . '/items');
                    if ($itemsResponse->successful()) {
                        $items = $itemsResponse->json();
                        
                        $subtotal = 0;
                        foreach ($items as $item) {
                            $productResponse = Http::get($this->apiBaseUrl . '/products/' . $item['product_id']);
                            if ($productResponse->successful()) {
                                $product = $productResponse->json();
                                $subtotal += $product['product_price'] * $item['quantity'];
                            }
                        }
                        $shipping = 200.00; // Fixed shipping fee of 200
                        $orders[$key]['total_amount'] = $subtotal + $shipping;
                    }
                }
            }
            
            return view('orders.index', compact('orders'));
        } catch (\Exception $e) {
            return view('orders.index', ['orders' => [], 'error' => 'Unable to fetch orders. ' . $e->getMessage()]);
        }
    }

    public function show($orderId)
    {
        try {
            $response = Http::get($this->apiBaseUrl . '/orders/' . $orderId);
            
            if ($response->failed()) {
                return redirect()->route('orders.index')->with('error', 'Order not found');
            }
            
            $order = $response->json();
            
            // Check if this order belongs to the authenticated user
            $userId = Session::get('user_id');
            if ($order['user_id'] != $userId) {
                return redirect()->route('orders.index')->with('error', 'Unauthorized access');
            }
            
            // Fetch cart information
            if (isset($order['cart_id'])) {
                $cartResponse = Http::get($this->apiBaseUrl . '/carts/' . $order['cart_id']);
                if ($cartResponse->successful()) {
                    $cart = $cartResponse->json();
                    
                    // Fetch cart items
                    $itemsResponse = Http::get($this->apiBaseUrl . '/carts/' . $order['cart_id'] . '/items');
                    if ($itemsResponse->successful()) {
                        $items = $itemsResponse->json();
                        
                        // Fetch full product details for each item including images
                        foreach ($items as $key => $item) {
                            $productResponse = Http::get($this->apiBaseUrl . '/products/' . $item['product_id']);
                            if ($productResponse->successful()) {
                                $product = $productResponse->json();
                                $items[$key]['product'] = $product;
                            }
                        }
                        
                        $order['items'] = $items;
                        
                        // Calculate order subtotal and total
                        $subtotal = 0;
                        foreach ($items as $item) {
                            $subtotal += $item['product']['product_price'] * $item['quantity'];
                        }
                        
                        $order['subtotal'] = $subtotal;
                        $order['shipping'] = 200.00; // Fixed shipping fee of 200
                        $order['total_amount'] = $subtotal + $order['shipping'];
                    }
                }
            }
            
            return view('orders.show', compact('order'));
        } catch (\Exception $e) {
            return redirect()->route('orders.index')->with('error', 'Error fetching order details: ' . $e->getMessage());
        }
    }

    public function checkout()
    {
        try {
            // Get user's active cart
            $userId = Session::get('user_id');
            $response = Http::get($this->apiBaseUrl . '/carts/user/' . $userId);
            
            if ($response->failed()) {
                return redirect()->route('cart.index')->with('error', 'No active cart found');
            }
            
            $cart = $response->json();
            
            // Get cart items to display on checkout page
            $itemsResponse = Http::get($this->apiBaseUrl . '/carts/' . $cart['cart_id'] . '/items');
            $items = $itemsResponse->json();
            
            // Calculate total
            $total = 0;
            foreach ($items as $item) {
                $total += $item['product']['product_price'] * $item['quantity'];
            }
            
            // Add shipping fee to total
            $shipping = 200.00;
            $grandTotal = $total + $shipping;
            
            return view('orders.checkout', compact('cart', 'items', 'total', 'shipping', 'grandTotal'));
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'Error preparing checkout: ' . $e->getMessage());
        }
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|min:5',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            'payment_method' => 'required|string'
        ]);

        try {
            // Get user's active cart
            $userId = Session::get('user_id');
            $response = Http::get($this->apiBaseUrl . '/carts/user/' . $userId);
            
            if ($response->failed()) {
                return redirect()->route('cart.index')->with('error', 'No active cart found');
            }
            
            $cart = $response->json();

            // Create a complete address
            $fullAddress = $request->address . ', ' . $request->city . ', ' . $request->state . ' ' . $request->zip;
            
            // Create the order
            $orderResponse = Http::post($this->apiBaseUrl . '/orders', [
                'user_id' => $userId,
                'cart_id' => $cart['cart_id'],
                'user_address' => $fullAddress,
                'payment_method' => $request->payment_method
            ]);
            
            if ($orderResponse->failed()) {
                return back()->with('error', 'Failed to create order: ' . $orderResponse->body());
            }
            
            $order = $orderResponse->json();
            
            return redirect()->route('orders.show', $order['order_id'])->with('success', 'Order placed successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }
} 