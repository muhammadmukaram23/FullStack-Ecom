<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    private $apiBaseUrl;
    private $adminUser = 'admin';
    private $adminPassword = 'admin123';

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL', 'http://127.0.0.1:8001/api');
        $this->middleware('admin.auth')->except(['showLogin', 'login', 'logout']);
    }

    public function showLogin()
    {
        if (Session::has('admin_logged_in') && Session::get('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($credentials['username'] === $this->adminUser && 
            $credentials['password'] === $this->adminPassword) {
            
            Session::put('admin_logged_in', true);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Session::forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        try {
            // Fetch data for dashboard
            $productsResponse = Http::get($this->apiBaseUrl . '/products?limit=5');
            $products = $productsResponse->json();
            
            $categoriesResponse = Http::get($this->apiBaseUrl . '/categories');
            $categories = $categoriesResponse->json();
            
            // Get all orders to calculate total sales
            $allOrdersResponse = Http::get($this->apiBaseUrl . '/orders');
            $allOrders = $allOrdersResponse->json();
            
            // Debug: Add first order's structure
            $firstOrderStructure = [];
            if (!empty($allOrders)) {
                $firstOrder = reset($allOrders);
                $firstOrderStructure['fields'] = array_keys($firstOrder);
                $firstOrderStructure['sample'] = $firstOrder;
                
                // If there's a cart_id, also fetch cart and items
                if (isset($firstOrder['cart_id'])) {
                    $cartResponse = Http::get($this->apiBaseUrl . '/carts/' . $firstOrder['cart_id']);
                    if ($cartResponse->successful()) {
                        $firstOrderStructure['cart'] = $cartResponse->json();
                        
                        $cartItemsResponse = Http::get($this->apiBaseUrl . '/carts/' . $firstOrder['cart_id'] . '/items');
                        if ($cartItemsResponse->successful()) {
                            $firstOrderStructure['cart_items'] = $cartItemsResponse->json();
                        }
                    }
                }
            }
            
            // Get recent orders for display
            $ordersResponse = Http::get($this->apiBaseUrl . '/orders?limit=5');
            $orders = $ordersResponse->json();
            
            // Calculate total sales from all orders
            $totalSales = 0;
            $orderDebugInfo = [];
            
            foreach ($allOrders as $order) {
                $orderAmount = 0;
                $orderId = $order['order_id'] ?? 'unknown';
                
                // First check if total_amount exists directly in the order
                if (isset($order['total_amount'])) {
                    $orderAmount = floatval($order['total_amount']);
                    $orderDebugInfo[] = "Order #{$orderId}: Found total_amount: {$orderAmount}";
                }
                // Next try total_price if available
                elseif (isset($order['total_price'])) {
                    // For total_price, assume it might be just the subtotal, add shipping fee
                    $subTotal = floatval($order['total_price']);
                    $shipping = 200.00;
                    $orderAmount = $subTotal + $shipping;
                    $orderDebugInfo[] = "Order #{$orderId}: Found total_price: {$subTotal}";
                    $orderDebugInfo[] = "  => Added shipping fee: {$shipping}";
                    $orderDebugInfo[] = "  => Total amount: {$orderAmount}";
                }
                // If neither exists, look for cart information
                elseif (isset($order['cart_id'])) {
                    $cartId = $order['cart_id'];
                    $orderDebugInfo[] = "Order #{$orderId}: Fetching cart #{$cartId} details";
                    
                    // Get cart items
                    $cartItemsResponse = Http::get($this->apiBaseUrl . '/carts/' . $cartId . '/items');
                    if ($cartItemsResponse->successful()) {
                        $cartItems = $cartItemsResponse->json();
                        $subTotal = 0;
                        
                        foreach ($cartItems as $item) {
                            // Try to get price and quantity
                            $price = isset($item['product_price']) ? floatval($item['product_price']) : 0;
                            $quantity = isset($item['quantity']) ? intval($item['quantity']) : 0;
                            
                            // If product price is not in cart item, fetch from product
                            if ($price == 0 && isset($item['product_id'])) {
                                $productResponse = Http::get($this->apiBaseUrl . '/products/' . $item['product_id']);
                                if ($productResponse->successful()) {
                                    $product = $productResponse->json();
                                    $price = isset($product['product_price']) ? floatval($product['product_price']) : 0;
                                }
                            }
                            
                            $itemTotal = $price * $quantity;
                            $subTotal += $itemTotal;
                            $orderDebugInfo[] = "  - Item: price={$price}, qty={$quantity}, subtotal={$itemTotal}";
                        }
                        
                        // Add shipping fee of 200.00
                        $shipping = 200.00;
                        $orderAmount = $subTotal + $shipping;
                        $orderDebugInfo[] = "  => Cart subtotal: {$subTotal}";
                        $orderDebugInfo[] = "  => Shipping fee: {$shipping}";
                        $orderDebugInfo[] = "  => Total amount: {$orderAmount}";
                    } else {
                        $orderDebugInfo[] = "  => Failed to fetch cart items";
                    }
                } 
                // Last resort - fetch order detail
                else {
                    $orderDetailResponse = Http::get($this->apiBaseUrl . '/orders/' . $orderId);
                    if ($orderDetailResponse->successful()) {
                        $orderDetail = $orderDetailResponse->json();
                        $orderDebugInfo[] = "Order #{$orderId}: Fetching order details";
                        
                        // Check different possible field names
                        if (isset($orderDetail['total_amount'])) {
                            $orderAmount = floatval($orderDetail['total_amount']);
                            $orderDebugInfo[] = "  => Found total_amount: {$orderAmount}";
                        } elseif (isset($orderDetail['total_price'])) {
                            // For total_price, assume it might be just the subtotal, add shipping fee
                            $subTotal = floatval($orderDetail['total_price']);
                            $shipping = 200.00;
                            $orderAmount = $subTotal + $shipping;
                            $orderDebugInfo[] = "  => Found total_price: {$subTotal}";
                            $orderDebugInfo[] = "  => Added shipping fee: {$shipping}";
                            $orderDebugInfo[] = "  => Total amount: {$orderAmount}";
                        } elseif (isset($orderDetail['amount'])) {
                            // For amount, assume it might be just the subtotal, add shipping fee
                            $subTotal = floatval($orderDetail['amount']);
                            $shipping = 200.00;
                            $orderAmount = $subTotal + $shipping;
                            $orderDebugInfo[] = "  => Found amount: {$subTotal}";
                            $orderDebugInfo[] = "  => Added shipping fee: {$shipping}";
                            $orderDebugInfo[] = "  => Total amount: {$orderAmount}";
                        } else {
                            $orderDebugInfo[] = "  => No price fields found in order detail";
                        }
                    } else {
                        $orderDebugInfo[] = "  => Failed to fetch order details";
                    }
                }
                
                $totalSales += $orderAmount;
                $orderDebugInfo[] = "  => Running total: {$totalSales}";
            }
            
            // Fetch users and ensure complete data
            $usersResponse = Http::get($this->apiBaseUrl . '/users');
            $users = $usersResponse->json();
            
            // Loop through each user and fetch complete details if needed (but only for dashboard users)
            $dashboardUsers = array_slice($users, 0, 5);
            foreach ($dashboardUsers as $key => $user) {
                // Check if any essential field is missing
                if (!isset($user['email']) || !isset($user['full_name'])) {
                    // Try to fetch complete user details for this specific user
                    $userId = $user['user_id'] ?? null;
                    if ($userId) {
                        $userDetailResponse = Http::get($this->apiBaseUrl . '/users/' . $userId);
                        if ($userDetailResponse->successful()) {
                            $userDetail = $userDetailResponse->json();
                            // Merge the detailed user data with existing data
                            $dashboardUsers[$key] = array_merge($user, $userDetail);
                        }
                    }
                    
                    // Even after the fetch attempt, ensure all essential fields have at least placeholder values
                    $dashboardUsers[$key]['email'] = $dashboardUsers[$key]['email'] ?? ($dashboardUsers[$key]['user_name'] ?? 'user') . '@example.com';
                    $dashboardUsers[$key]['full_name'] = $dashboardUsers[$key]['full_name'] ?? $dashboardUsers[$key]['user_name'] ?? 'Unknown';
                }
            }
            
            $stats = [
                'products' => count($products ?? []),
                'categories' => count($categories ?? []),
                'orders' => count($orders ?? []),
                'users' => count($users ?? []),
                'total_sales' => $totalSales,
                'order_debug' => $orderDebugInfo,
                'first_order' => $firstOrderStructure
            ];
            
            return view('admin.dashboard', compact('stats', 'products', 'orders', 'dashboardUsers'));
        } catch (\Exception $e) {
            return view('admin.dashboard', ['error' => 'Error fetching data: ' . $e->getMessage()]);
        }
    }

    public function products()
    {
        try {
            $response = Http::get($this->apiBaseUrl . '/products');
            $products = $response->json();
            
            $categoriesResponse = Http::get($this->apiBaseUrl . '/categories');
            $categories = $categoriesResponse->json();
            
            return view('admin.products.index', compact('products', 'categories'));
        } catch (\Exception $e) {
            return view('admin.products.index', ['error' => 'Error fetching products: ' . $e->getMessage()]);
        }
    }

    public function editProduct($id)
    {
        try {
            $response = Http::get($this->apiBaseUrl . '/products/' . $id);
            
            if (!$response->successful()) {
                return redirect()->route('admin.products')->with('error', 'Product not found');
            }
            
            $product = $response->json();
            
            $categoriesResponse = Http::get($this->apiBaseUrl . '/categories');
            $categories = $categoriesResponse->json();
            
            return view('admin.products.edit', compact('product', 'categories'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error fetching product: ' . $e->getMessage());
        }
    }

    public function updateProduct(Request $request, $id)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:100',
            'product_description' => 'required|string',
            'product_price' => 'required|numeric|min:0',
            'category_id' => 'required|integer',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            // Update product
            $response = Http::put($this->apiBaseUrl . '/products/' . $id, [
                'product_name' => $validatedData['product_name'],
                'product_description' => $validatedData['product_description'],
                'product_price' => $validatedData['product_price'],
                'category_id' => $validatedData['category_id']
            ]);

            if (!$response->successful()) {
                return back()->withErrors(['error' => 'Failed to update product'])->withInput();
            }

            $product = $response->json();

            // Handle new image uploads
            $uploadedImages = [];
            if ($request->hasFile('new_images')) {
                foreach ($request->file('new_images') as $image) {
                    // Create a unique filename
                    $fileName = time() . '_' . $image->getClientOriginalName();
                    
                    // Store the image in the public directory
                    $image->move(public_path('uploads/products'), $fileName);
                    
                    // Full URL to the image
                    $imageUrl = asset('uploads/products/' . $fileName);
                    
                    // Add product image to the API
                    $imageResponse = Http::post($this->apiBaseUrl . '/products/' . $id . '/images', [
                        'image_url' => $imageUrl
                    ]);
                    
                    if ($imageResponse->successful()) {
                        $uploadedImages[] = $imageResponse->json();
                    }
                }
            }

            $message = 'Product updated successfully';
            if (count($uploadedImages) > 0) {
                $message .= ' with ' . count($uploadedImages) . ' new images';
            }

            return redirect()->route('admin.products')->with('success', $message);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error updating product: ' . $e->getMessage()])->withInput();
        }
    }

    public function deleteProduct($id)
    {
        try {
            $response = Http::delete($this->apiBaseUrl . '/products/' . $id);

            if (!$response->successful()) {
                return back()->with('error', 'Failed to delete product');
            }

            return redirect()->route('admin.products')->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting product: ' . $e->getMessage());
        }
    }

    public function deleteProductImage(Request $request)
    {
        $request->validate([
            'image_id' => 'required|integer'
        ]);

        try {
            $response = Http::delete($this->apiBaseUrl . '/products/images/' . $request->image_id);

            if ($response->successful()) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to delete image']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function showProductForm()
    {
        try {
            $categoriesResponse = Http::get($this->apiBaseUrl . '/categories');
            $categories = $categoriesResponse->json();
            
            return view('admin.products.create', compact('categories'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error fetching categories: ' . $e->getMessage());
        }
    }

    public function createProduct(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'product_name' => 'required|string|max:100',
                'product_description' => 'required|string',
                'product_price' => 'required|numeric|min:0',
                'category_id' => 'required|integer',
                'product_images' => 'nullable|array',
                'product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);

            \Log::info('Product creation attempt', [
                'product_name' => $validatedData['product_name'],
                'product_price' => $validatedData['product_price'],
                'request_data' => $request->all()
            ]);

            // Create product
            $apiUrl = $this->apiBaseUrl . '/products';
            $postData = [
                'product_name' => $validatedData['product_name'],
                'product_description' => $validatedData['product_description'],
                'product_price' => $validatedData['product_price'],
                'category_id' => $validatedData['category_id']
            ];
            
            \Log::info('Sending product creation request', [
                'url' => $apiUrl,
                'data' => $postData
            ]);
            
            $response = Http::post($apiUrl, $postData);
            
            \Log::info('API response for product creation', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if (!$response->successful()) {
                // Log failed product creation
                \Log::error('Failed to create product: ' . $response->body());
                return back()->withErrors(['error' => 'Failed to create product: ' . $response->body()])->withInput();
            }

            $product = $response->json();
            $productId = $product['product_id'];

            // Log successful product creation
            \Log::info('Product created successfully: ', ['product_id' => $productId]);

            // Handle multiple image uploads
            $uploadedImages = [];
            if ($request->hasFile('product_images')) {
                \Log::info('Found product images to upload', ['count' => count($request->file('product_images'))]);
                
                foreach ($request->file('product_images') as $index => $image) {
                    try {
                        // Log details about each image
                        \Log::info('Processing image', [
                            'index' => $index,
                            'original_name' => $image->getClientOriginalName(),
                            'mime_type' => $image->getMimeType(),
                            'size' => $image->getSize(),
                            'extension' => $image->getClientOriginalExtension()
                        ]);
                        
                        // Create a unique filename
                        $fileName = time() . '_' . $image->getClientOriginalName();
                        
                        // Store the image in the public directory
                        $uploadPath = public_path('uploads/products');
                        \Log::info('Upload path: ' . $uploadPath);
                        
                        // Check if directory exists, if not create it
                        if (!file_exists($uploadPath)) {
                            mkdir($uploadPath, 0755, true);
                            \Log::info('Created directory: ' . $uploadPath);
                        }
                        
                        // Move the file
                        if ($image->move($uploadPath, $fileName)) {
                            \Log::info('Image uploaded successfully: ' . $fileName);
                        } else {
                            \Log::error('Failed to move uploaded file');
                            continue;
                        }
                        
                        // Get the server's public URL
                        // This uses direct URL instead of asset() helper which might not be accessible from API
                        // Adjust this URL based on your server configuration
                        $serverUrl = request()->getSchemeAndHttpHost();
                        $imageUrl = $serverUrl . '/uploads/products/' . $fileName;
                        \Log::info('Image URL: ' . $imageUrl);
                        
                        // Add product image to the API
                        $imageApiUrl = $this->apiBaseUrl . '/products/' . $productId . '/images';
                        $imageData = ['image_url' => $imageUrl];
                        
                        \Log::info('Sending image data to API', [
                            'url' => $imageApiUrl,
                            'data' => $imageData
                        ]);
                        
                        $imageResponse = Http::post($imageApiUrl, $imageData);
                        
                        // Log the API response for image upload
                        \Log::info('Image upload API response', [
                            'status' => $imageResponse->status(),
                            'body' => $imageResponse->body()
                        ]);
                        
                        if ($imageResponse->successful()) {
                            $uploadedImages[] = $imageResponse->json();
                        } else {
                            \Log::error('Failed to save image to API', [
                                'status' => $imageResponse->status(),
                                'body' => $imageResponse->body()
                            ]);
                        }
                    } catch (\Exception $e) {
                        \Log::error('Error processing image: ' . $e->getMessage(), [
                            'file' => $e->getFile(),
                            'line' => $e->getLine()
                        ]);
                    }
                }
            } else {
                \Log::warning('No image files found in request', [
                    'files' => $request->allFiles(),
                    'hasFile_result' => $request->hasFile('product_images')
                ]);
            }

            // Return success even if images don't upload
            $message = 'Product created successfully';
            if (count($uploadedImages) > 0) {
                $message .= ' with ' . count($uploadedImages) . ' images';
            } elseif ($request->hasFile('product_images')) {
                $message .= ' but image upload failed';
            }

            \Log::info($message, ['image_count' => count($uploadedImages)]);
            return redirect()->route('admin.products')->with('success', $message);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in createProduct: ', [
                'errors' => $e->errors()
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Exception in createProduct: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'Error creating product: ' . $e->getMessage()])->withInput();
        }
    }

    public function categories()
    {
        try {
            $response = Http::get($this->apiBaseUrl . '/categories');
            $categories = $response->json();
            
            return view('admin.categories.index', compact('categories'));
        } catch (\Exception $e) {
            return view('admin.categories.index', ['error' => 'Error fetching categories: ' . $e->getMessage()]);
        }
    }

    public function showCategoryForm()
    {
        return view('admin.categories.create');
    }

    public function createCategory(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:100'
        ]);

        try {
            $response = Http::post($this->apiBaseUrl . '/categories', [
                'category_name' => $validatedData['category_name']
            ]);

            if (!$response->successful()) {
                return back()->withErrors(['error' => 'Failed to create category'])->withInput();
            }

            return redirect()->route('admin.categories')->with('success', 'Category created successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error creating category: ' . $e->getMessage()])->withInput();
        }
    }

    public function editCategory($id)
    {
        try {
            $response = Http::get($this->apiBaseUrl . '/categories/' . $id);
            
            if (!$response->successful()) {
                return redirect()->route('admin.categories')->with('error', 'Category not found');
            }
            
            $category = $response->json();
            
            return view('admin.categories.edit', compact('category'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error fetching category: ' . $e->getMessage());
        }
    }
    
    public function updateCategory(Request $request, $id)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:100'
        ]);

        try {
            $response = Http::put($this->apiBaseUrl . '/categories/' . $id, [
                'category_name' => $validatedData['category_name']
            ]);

            if (!$response->successful()) {
                return back()->withErrors(['error' => 'Failed to update category'])->withInput();
            }

            return redirect()->route('admin.categories')->with('success', 'Category updated successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error updating category: ' . $e->getMessage()])->withInput();
        }
    }
    
    public function deleteCategory($id)
    {
        try {
            $response = Http::delete($this->apiBaseUrl . '/categories/' . $id);

            if (!$response->successful()) {
                return back()->with('error', 'Failed to delete category');
            }

            return redirect()->route('admin.categories')->with('success', 'Category deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting category: ' . $e->getMessage());
        }
    }

    public function orders()
    {
        try {
            $response = Http::get($this->apiBaseUrl . '/orders');
            $orders = $response->json();
            
            // Fetch user details and order items for each order
            foreach ($orders as $key => $order) {
                // Fetch user details
                $userResponse = Http::get($this->apiBaseUrl . '/users/' . $order['user_id']);
                if ($userResponse->successful()) {
                    $orders[$key]['user_details'] = $userResponse->json();
                }
                
                // Fetch cart and items for preview
                $cartResponse = Http::get($this->apiBaseUrl . '/carts/' . $order['cart_id']);
                if ($cartResponse->successful()) {
                    $cart = $cartResponse->json();
                    
                    // Fetch cart items 
                    $itemsResponse = Http::get($this->apiBaseUrl . '/carts/' . $order['cart_id'] . '/items');
                    if ($itemsResponse->successful()) {
                        $items = $itemsResponse->json();
                        $cart['cart_items'] = $items;
                        
                        // Fetch product details for each item
                        foreach ($cart['cart_items'] as $i => $item) {
                            $productResponse = Http::get($this->apiBaseUrl . '/products/' . $item['product_id']);
                            if ($productResponse->successful()) {
                                $cart['cart_items'][$i]['product'] = $productResponse->json();
                            }
                        }
                    }
                    
                    $orders[$key]['cart'] = $cart;
                }
            }
            
            return view('admin.orders.index', compact('orders'));
        } catch (\Exception $e) {
            return view('admin.orders.index', ['error' => 'Error fetching orders: ' . $e->getMessage()]);
        }
    }

    public function viewOrder($id)
    {
        try {
            $response = Http::get($this->apiBaseUrl . '/orders/' . $id);
            
            if (!$response->successful()) {
                return redirect()->route('admin.orders')->with('error', 'Order not found');
            }
            
            $order = $response->json();
            
            // Fetch user details
            $userResponse = Http::get($this->apiBaseUrl . '/users/' . $order['user_id']);
            if ($userResponse->successful()) {
                $order['user_details'] = $userResponse->json();
            }
            
            // Fetch cart information
            $cartResponse = Http::get($this->apiBaseUrl . '/carts/' . $order['cart_id']);
            if ($cartResponse->successful()) {
                $cart = $cartResponse->json();
                
                // Fetch cart items
                $itemsResponse = Http::get($this->apiBaseUrl . '/carts/' . $order['cart_id'] . '/items');
                if ($itemsResponse->successful()) {
                    $items = $itemsResponse->json();
                    $cart['cart_items'] = $items;
                    
                    // Fetch product details for each item
                    foreach ($cart['cart_items'] as $i => $item) {
                        $productResponse = Http::get($this->apiBaseUrl . '/products/' . $item['product_id']);
                        if ($productResponse->successful()) {
                            $product = $productResponse->json();
                            
                            // Fetch product category
                            if (isset($product['category_id'])) {
                                $categoryResponse = Http::get($this->apiBaseUrl . '/categories/' . $product['category_id']);
                                if ($categoryResponse->successful()) {
                                    $product['category'] = $categoryResponse->json();
                                }
                            }
                            
                            $cart['cart_items'][$i]['product'] = $product;
                        }
                    }
                }
                
                $order['cart'] = $cart;
            }
            
            return view('admin.orders.view', compact('order'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error fetching order details: ' . $e->getMessage());
        }
    }

    public function contacts()
    {
        try {
            $response = Http::get($this->apiBaseUrl . '/contacts');
            $contacts = $response->json();
            
            return view('admin.contacts.index', compact('contacts'));
        } catch (\Exception $e) {
            return view('admin.contacts.index', ['error' => 'Error fetching contacts: ' . $e->getMessage()]);
        }
    }

    public function users()
    {
        try {
            // Get all users from the API
            $response = Http::get($this->apiBaseUrl . '/users');
            $users = $response->json();
            
            // Loop through each user and fetch complete details if needed
            foreach ($users as $key => $user) {
                // Check if any essential field is missing
                if (!isset($user['email']) || !isset($user['full_name']) || !isset($user['hashed_password'])) {
                    // Try to fetch complete user details for this specific user
                    $userId = $user['user_id'] ?? null;
                    if ($userId) {
                        $userDetailResponse = Http::get($this->apiBaseUrl . '/users/' . $userId);
                        if ($userDetailResponse->successful()) {
                            $userDetail = $userDetailResponse->json();
                            // Merge the detailed user data with existing data
                            $users[$key] = array_merge($user, $userDetail);
                        }
                    }
                    
                    // Even after the fetch attempt, ensure all essential fields have at least placeholder values
                    // This handles the case where the individual user endpoint also doesn't provide all fields
                    $users[$key]['email'] = $users[$key]['email'] ?? ($users[$key]['user_name'] ?? 'user') . '@example.com';
                    $users[$key]['full_name'] = $users[$key]['full_name'] ?? $users[$key]['user_name'] ?? 'Unknown';
                    $users[$key]['hashed_password'] = $users[$key]['hashed_password'] ?? '********';
                    $users[$key]['created_at'] = $users[$key]['created_at'] ?? date('Y-m-d H:i:s');
                }
            }
            
            return view('admin.users.index', compact('users'));
        } catch (\Exception $e) {
            return view('admin.users.index', ['error' => 'Error fetching users: ' . $e->getMessage()]);
        }
    }

    public function deleteUser($id)
    {
        try {
            $response = Http::delete($this->apiBaseUrl . '/users/' . $id);

            if (!$response->successful()) {
                return back()->with('error', 'Failed to delete user');
            }

            return redirect()->route('admin.users')->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }
} 