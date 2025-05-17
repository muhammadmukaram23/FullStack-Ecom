<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL', 'http://127.0.0.1:8001/api');
    }

    public function index(Request $request)
    {
        try {
            // Get all products
            $response = Http::get($this->apiBaseUrl . '/products');
            $products = $response->json();
            
            // Get categories for filtering
            $categoriesResponse = Http::get($this->apiBaseUrl . '/categories');
            $categories = $categoriesResponse->json();
            
            // Apply category filter if it exists
            $categoryId = $request->input('category');
            if ($categoryId) {
                $filteredProducts = [];
                foreach ($products as $product) {
                    if ($product['category_id'] == $categoryId) {
                        $filteredProducts[] = $product;
                    }
                }
                $products = $filteredProducts;
            }
            
            // Apply price range filter if it exists
            $priceRange = $request->input('price');
            $minPrice = $request->input('min_price');
            $maxPrice = $request->input('max_price');
            
            if ($priceRange || ($minPrice !== null && $maxPrice !== null)) {
                $filteredProducts = [];
                
                foreach ($products as $product) {
                    $price = floatval($product['product_price']);
                    
                    // Handle predefined price ranges
                    if ($priceRange == 'under-50' && $price < 50) {
                        $filteredProducts[] = $product;
                    } elseif ($priceRange == '50-100' && $price >= 50 && $price <= 100) {
                        $filteredProducts[] = $product;
                    } elseif ($priceRange == '100-plus' && $price > 100) {
                        $filteredProducts[] = $product;
                    }
                    // Handle custom price range
                    elseif (!$priceRange && $minPrice !== null && $maxPrice !== null) {
                        $min = floatval($minPrice);
                        $max = floatval($maxPrice);
                        
                        if ($price >= $min && ($max === 0 || $price <= $max)) {
                            $filteredProducts[] = $product;
                        }
                    }
                }
                
                // If a price filter was applied, use the filtered products
                if ($priceRange || ($minPrice !== null && $maxPrice !== null)) {
                    $products = $filteredProducts;
                }
            }
            
            // Apply sorting
            $sortOption = $request->input('sort', 'newest');
            
            if ($sortOption == 'price-asc') {
                // Sort by price low to high
                usort($products, function($a, $b) {
                    return floatval($a['product_price']) <=> floatval($b['product_price']);
                });
            } elseif ($sortOption == 'price-desc') {
                // Sort by price high to low
                usort($products, function($a, $b) {
                    return floatval($b['product_price']) <=> floatval($a['product_price']);
                });
            } elseif ($sortOption == 'name-asc') {
                // Sort by name A-Z
                usort($products, function($a, $b) {
                    return strcmp($a['product_name'], $b['product_name']);
                });
            } elseif ($sortOption == 'name-desc') {
                // Sort by name Z-A
                usort($products, function($a, $b) {
                    return strcmp($b['product_name'], $a['product_name']);
                });
            }
            // Default is 'newest' - assuming products are already in that order from API
            
            return view('products.index', compact('products', 'categories', 'priceRange', 'minPrice', 'maxPrice', 'sortOption', 'categoryId'));
        } catch (\Exception $e) {
            return view('products.index', ['products' => [], 'categories' => [], 'error' => 'Unable to fetch products. ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $response = Http::get($this->apiBaseUrl . '/products/' . $id);
            
            if ($response->failed()) {
                return redirect()->route('products.index')->with('error', 'Product not found');
            }
            
            $product = $response->json();
            
            // Get product images
            $imagesResponse = Http::get($this->apiBaseUrl . '/products/' . $id . '/images');
            $images = $imagesResponse->json();
            
            return view('products.show', compact('product', 'images'));
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Error fetching product details');
        }
    }

    public function byCategory($categoryId, Request $request)
    {
        try {
            $response = Http::get($this->apiBaseUrl . '/products/category/' . $categoryId);
            $products = $response->json();
            
            // Fetch images for each product
            foreach ($products as $key => $product) {
                $imagesResponse = Http::get($this->apiBaseUrl . '/products/' . $product['product_id'] . '/images');
                if ($imagesResponse->successful()) {
                    $products[$key]['images'] = $imagesResponse->json();
                }
            }
            
            // Apply price range filter if it exists
            $priceRange = $request->input('price');
            $minPrice = $request->input('min_price');
            $maxPrice = $request->input('max_price');
            
            if ($priceRange || ($minPrice !== null && $maxPrice !== null)) {
                $filteredProducts = [];
                
                foreach ($products as $product) {
                    $price = floatval($product['product_price']);
                    
                    // Handle predefined price ranges
                    if ($priceRange == 'under-50' && $price < 50) {
                        $filteredProducts[] = $product;
                    } elseif ($priceRange == '50-100' && $price >= 50 && $price <= 100) {
                        $filteredProducts[] = $product;
                    } elseif ($priceRange == '100-plus' && $price > 100) {
                        $filteredProducts[] = $product;
                    }
                    // Handle custom price range
                    elseif (!$priceRange && $minPrice !== null && $maxPrice !== null) {
                        $min = floatval($minPrice);
                        $max = floatval($maxPrice);
                        
                        if ($price >= $min && ($max === 0 || $price <= $max)) {
                            $filteredProducts[] = $product;
                        }
                    }
                }
                
                // If a price filter was applied, use the filtered products
                if ($priceRange || ($minPrice !== null && $maxPrice !== null)) {
                    $products = $filteredProducts;
                }
            }
            
            // Get category info
            $categoryResponse = Http::get($this->apiBaseUrl . '/categories/' . $categoryId);
            $category = $categoryResponse->json();
            
            // Get all categories for the filter
            $categoriesResponse = Http::get($this->apiBaseUrl . '/categories');
            $categories = $categoriesResponse->json();
            
            return view('products.category', compact('products', 'category', 'categories', 'priceRange', 'minPrice', 'maxPrice'));
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Error fetching products by category: ' . $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        try {
            $searchQuery = $request->input('query');
            
            if (empty($searchQuery)) {
                return redirect()->route('products.index');
            }
            
            // Get all products first
            $response = Http::get($this->apiBaseUrl . '/products');
            $allProducts = $response->json();
            
            // Filter products based on search query
            $products = array_filter($allProducts, function($product) use ($searchQuery) {
                // Search in product name
                if (stripos($product['product_name'], $searchQuery) !== false) {
                    return true;
                }
                
                // Search in product description
                if (isset($product['product_description']) && 
                    stripos($product['product_description'], $searchQuery) !== false) {
                    return true;
                }
                
                return false;
            });
            
            // Get categories for the sidebar filter
            $categoriesResponse = Http::get($this->apiBaseUrl . '/categories');
            $categories = $categoriesResponse->json();
            
            // Reset array keys
            $products = array_values($products);
            
            return view('products.search', [
                'products' => $products, 
                'categories' => $categories,
                'searchQuery' => $searchQuery
            ]);
        } catch (\Exception $e) {
            return redirect()->route('products.index')
                ->with('error', 'Error searching products: ' . $e->getMessage());
        }
    }
} 