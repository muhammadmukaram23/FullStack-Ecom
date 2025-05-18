@extends('layouts.app')

@section('title', 'Products')

@section('styles')
<style>
    /* Product Card Styles */
    .product-card {
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    .product-image-container {
        position: relative;
        height: 220px;
        background: #f9fafb;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .product-image {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
        padding: 10px;
        transition: transform 0.5s ease;
    }
    
    .product-image:hover {
        transform: scale(1.05);
    }
    
    .product-info {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    
    .product-title {
        font-weight: 600;
        font-size: 1.125rem;
        margin-bottom: 0.5rem;
        color: #1f2937;
        transition: color 0.3s ease;
    }
    
    .product-title:hover {
        color: #ca8a04;
    }
    
    .product-description {
        color: #6b7280;
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }
    
    .product-price-cart {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }
    
    .product-price {
        font-weight: 700;
        font-size: 1.25rem;
        color: #1f2937;
    }
    
    .add-to-cart {
        background-color: #ca8a04;
        color: white;
        border-radius: 9999px;
        padding: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .add-to-cart:hover {
        background-color: #a16207;
        transform: scale(1.1);
    }
    
    .line-clamp-1 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
    }
    
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }
</style>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-2">Shop Our Collection</h1>
            <p class="text-gray-600">Discover our wide range of high-quality products</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Filters - 1/4 width on large screens -->
            <div class="lg:col-span-1">
                <form id="filter-form" action="{{ route('products.index') }}" method="GET" class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="bg-yellow-600 text-white p-4">
                        <h2 class="text-lg font-bold">Shop Filters</h2>
                    </div>
                    
                    <div class="p-5">
                        <!-- Category Filter -->
                        <div class="mb-6">
                            <h3 class="font-medium text-gray-800 mb-3 pb-2 border-b border-gray-100 flex items-center">
                                <i class="fas fa-tags mr-2 text-yellow-600"></i>Categories
                            </h3>
                            <div class="space-y-2 pl-1">
                                <div class="flex items-center">
                                    <input type="radio" id="all-categories" name="category" value="" {{ empty($categoryId) ? 'checked' : '' }} 
                                        class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300">
                                    <label for="all-categories" class="ml-2 text-gray-700 hover:text-yellow-600 cursor-pointer">All Categories</label>
                                </div>
                                
                                @if(isset($categories) && count($categories) > 0)
                                    @foreach($categories as $category)
                                        <div class="flex items-center">
                                            <input type="radio" id="category-{{ $category['category_id'] }}" name="category" value="{{ $category['category_id'] }}" 
                                                {{ isset($categoryId) && $categoryId == $category['category_id'] ? 'checked' : '' }} 
                                                class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300">
                                            <label for="category-{{ $category['category_id'] }}" class="ml-2 text-gray-700 hover:text-yellow-600 cursor-pointer">{{ $category['category_name'] }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        
                        <!-- Price Range Filter -->
                        <div class="mb-6">
                            <h3 class="font-medium text-gray-800 mb-3 pb-2 border-b border-gray-100 flex items-center">
                                <i class="fas fa-dollar-sign mr-2 text-yellow-600"></i>Price Range
                            </h3>
                            <div class="space-y-2 pl-1">
                                <div class="flex items-center">
                                    <input type="radio" id="price-all" name="price" value="" {{ empty($priceRange) ? 'checked' : '' }} 
                                        class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300">
                                    <label for="price-all" class="ml-2 text-gray-700 hover:text-yellow-600 cursor-pointer">All Prices</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="price-under-50" name="price" value="under-50" {{ $priceRange == 'under-50' ? 'checked' : '' }} 
                                        class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300">
                                    <label for="price-under-50" class="ml-2 text-gray-700 hover:text-yellow-600 cursor-pointer">Under $50</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="price-50-100" name="price" value="50-100" {{ $priceRange == '50-100' ? 'checked' : '' }} 
                                        class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300">
                                    <label for="price-50-100" class="ml-2 text-gray-700 hover:text-yellow-600 cursor-pointer">$50 - $100</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="price-100-plus" name="price" value="100-plus" {{ $priceRange == '100-plus' ? 'checked' : '' }} 
                                        class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300">
                                    <label for="price-100-plus" class="ml-2 text-gray-700 hover:text-yellow-600 cursor-pointer">$100 & Above</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Custom Price Range -->
                        <div class="mb-6">
                            <h3 class="font-medium text-gray-800 mb-3 pb-2 border-b border-gray-100 flex items-center">
                                <i class="fas fa-sliders-h mr-2 text-yellow-600"></i>Custom Price
                            </h3>
                            <div class="space-y-3">
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">$</span>
                                    <input type="number" name="min_price" id="min-price" placeholder="Min" min="0" value="{{ $minPrice ?? '' }}" 
                                        class="pl-7 w-full border border-gray-200 rounded-md p-2 focus:ring-2 focus:ring-yellow-600 focus:border-yellow-600">
                                </div>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">$</span>
                                    <input type="number" name="max_price" id="max-price" placeholder="Max" min="0" value="{{ $maxPrice ?? '' }}" 
                                        class="pl-7 w-full border border-gray-200 rounded-md p-2 focus:ring-2 focus:ring-yellow-600 focus:border-yellow-600">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sort Options (hidden) -->
                        @isset($sortOption)
                            <input type="hidden" name="sort" value="{{ $sortOption }}" id="sort-hidden-input">
                        @endisset
                        
                        <!-- Apply Filters Button -->
                        <button type="submit" class="w-full bg-yellow-600 text-white py-3 rounded-lg hover:bg-yellow-700 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center">
                            <i class="fas fa-filter mr-2"></i>Apply Filters
                        </button>
                        
                        @if($priceRange || isset($minPrice) || isset($maxPrice) || isset($categoryId) || isset($sortOption))
                        <a href="{{ route('products.index') }}" class="mt-3 block text-center w-full text-yellow-600 py-2 border border-yellow-600 rounded-lg hover:bg-yellow-50 transition">
                            <i class="fas fa-times mr-1"></i>Clear All Filters
                        </a>
                        @endif
                    </div>
                </form>
            </div>
            
            <!-- Products Grid - 3/4 width on large screens -->
            <div class="lg:col-span-3">
                <!-- Sort & View Controls -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 mb-6">
                    <div class="bg-gray-50 p-4 border-b border-gray-100">
                        <h2 class="text-lg font-medium text-gray-700">Products</h2>
                    </div>
                    <div class="p-4 flex flex-col sm:flex-row justify-between items-center">
                        <div class="mb-4 sm:mb-0 w-full sm:w-auto relative">
                            <div class="flex items-center">
                                <i class="fas fa-sort text-yellow-600 mr-2"></i>
                                <label for="sort-options" class="text-gray-600 mr-2">Sort by:</label>
                                <div class="relative w-full sm:w-auto">
                                    <select id="sort-options" class="appearance-none w-full sm:w-auto pl-3 pr-10 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:border-yellow-600 bg-white cursor-pointer text-gray-700">
                                        <option value="newest" {{ isset($sortOption) && $sortOption == 'newest' ? 'selected' : '' }}>Newest</option>
                                        <option value="name-asc" {{ isset($sortOption) && $sortOption == 'name-asc' ? 'selected' : '' }}>Name (A-Z)</option>
                                        <option value="name-desc" {{ isset($sortOption) && $sortOption == 'name-desc' ? 'selected' : '' }}>Name (Z-A)</option>
                                        <option value="price-asc" {{ isset($sortOption) && $sortOption == 'price-asc' ? 'selected' : '' }}>Price (Low to High)</option>
                                        <option value="price-desc" {{ isset($sortOption) && $sortOption == 'price-desc' ? 'selected' : '' }}>Price (High to Low)</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                            <button class="p-2 px-3 bg-yellow-600 text-white hover:bg-yellow-700 focus:outline-none transition" title="Grid View">
                                <i class="fas fa-th"></i>
                            </button>
                            <button class="p-2 px-3 bg-white text-gray-600 hover:bg-gray-100 focus:outline-none transition" title="List View">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Products Grid -->
                @if(isset($products) && count($products) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 product-card">
                                <a href="{{ route('products.show', $product['product_id']) }}" class="block">
                                    <div class="product-image-container">
                                        @if(isset($product['images']) && count($product['images']) > 0)
                                            <img src="{{ $product['images'][0]['image_url'] }}" alt="{{ $product['product_name'] }}" class="product-image">
                                        @else
                                            <img src="https://via.placeholder.com/300x300" alt="{{ $product['product_name'] }}" class="product-image">
                                        @endif
                                        
                                        <div class="absolute top-0 right-0 mt-3 mr-3 transform transition hover:scale-110">
                                            <button class="wishlist-button bg-white text-gray-700 hover:text-yellow-600 p-2 rounded-full shadow-md transition"
                                                   data-product-id="{{ $product['product_id'] }}">
                                                <i class="far fa-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                </a>
                                
                                <div class="product-info">
                                    <a href="{{ route('products.show', $product['product_id']) }}" class="block">
                                        <h3 class="product-title">{{ $product['product_name'] }}</h3>
                                    </a>
                                    
                                    <p class="product-description line-clamp-2">
                                        {{ $product['product_description'] }}
                                    </p>
                                    
                                    <div class="product-price-cart">
                                        <span class="product-price">${{ number_format($product['product_price'], 2) }}</span>
                                        
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product['product_id'] }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="add-to-cart">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-xl shadow-sm p-8 text-center border border-gray-100">
                        <div class="text-gray-500 mb-6">
                            <i class="fas fa-box-open text-6xl mb-4"></i>
                            <h2 class="text-2xl font-bold mb-2">No products found</h2>
                            <p>We couldn't find any products that match your criteria.</p>
                        </div>
                        <a href="{{ route('products.index') }}" class="bg-primary-600 text-white font-medium px-6 py-2 rounded-lg hover:bg-primary-700 inline-block transition shadow-sm">
                            Clear Filters
                        </a>
                    </div>
                @endif
                
                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    <nav class="rounded-xl shadow-md overflow-hidden border border-gray-100">
                        <div class="flex items-center divide-x divide-gray-200">
                            <a href="#" class="px-4 py-3 bg-white text-gray-600 hover:bg-gray-50 hover:text-yellow-600 flex items-center transition">
                                <i class="fas fa-chevron-left text-xs mr-1"></i>
                                <span class="hidden sm:inline-block">Previous</span>
                            </a>
                            <a href="#" class="px-4 py-3 bg-yellow-600 text-white hover:bg-yellow-700 transition">
                                1
                            </a>
                            <a href="#" class="px-4 py-3 bg-white text-gray-700 hover:bg-gray-50 hover:text-yellow-600 transition">
                                2
                            </a>
                            <a href="#" class="px-4 py-3 bg-white text-gray-700 hover:bg-gray-50 hover:text-yellow-600 transition">
                                3
                            </a>
                            <span class="px-4 py-3 bg-white text-gray-400">
                                ...
                            </span>
                            <a href="#" class="px-4 py-3 bg-white text-gray-700 hover:bg-gray-50 hover:text-yellow-600 transition">
                                8
                            </a>
                            <a href="#" class="px-4 py-3 bg-white text-gray-600 hover:bg-gray-50 hover:text-yellow-600 flex items-center transition">
                                <span class="hidden sm:inline-block">Next</span>
                                <i class="fas fa-chevron-right text-xs ml-1"></i>
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Sort functionality
    document.getElementById('sort-options').addEventListener('change', function() {
        // Update hidden sort input in filter form
        document.getElementById('sort-hidden-input').value = this.value;
        // Submit the filter form
        document.getElementById('filter-form').submit();
    });
    
    // Clear custom price range when using predefined ranges
    document.querySelectorAll('input[name="price"]').forEach(input => {
        input.addEventListener('change', function() {
            document.getElementById('min-price').value = '';
            document.getElementById('max-price').value = '';
        });
    });
    
    // Clear predefined price ranges when using custom range
    document.querySelectorAll('#min-price, #max-price').forEach(input => {
        input.addEventListener('input', function() {
            if (this.value) {
                document.querySelectorAll('input[name="price"]').forEach(radio => {
                    radio.checked = false;
                });
                document.getElementById('price-all').checked = true;
            }
        });
    });
</script>
@endsection 