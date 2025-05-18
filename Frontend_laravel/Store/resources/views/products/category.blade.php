@extends('layouts.app')

@section('title', $category['category_name'] ?? 'Category Products')

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
        color: #0ea5e9;
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
        background-color: #0ea5e9;
        color: white;
        border-radius: 9999px;
        padding: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .add-to-cart:hover {
        background-color: #0284c7;
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
        <!-- Breadcrumbs -->
        <nav class="text-sm mb-6">
            <ol class="list-none p-0 flex flex-wrap items-center bg-white shadow-sm rounded-lg px-4 py-3">
                <li class="flex items-center">
                    <a href="{{ route('home') }}" class="text-primary-600 hover:text-primary-800 font-medium">Home</a>
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('products.index') }}" class="text-primary-600 hover:text-primary-800 font-medium">Products</a>
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                </li>
                <li class="text-gray-700 font-medium">{{ $category['category_name'] ?? 'Category' }}</li>
            </ol>
        </nav>
        
        <!-- Category Header -->
        <div class="bg-gradient-to-r from-primary-600 to-secondary-600 text-white p-8 rounded-xl mb-8 relative overflow-hidden">
            <!-- Animated Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>
            </div>
            <div class="relative z-10">
                <span class="inline-block px-3 py-1 bg-white bg-opacity-20 backdrop-blur-sm text-white text-sm font-medium rounded-full mb-3">COLLECTION</span>
                <h1 class="text-3xl font-bold mb-2">{{ $category['category_name'] ?? 'Category' }}</h1>
                <p class="text-gray-100 max-w-2xl">
                    {{ $category['category_description'] ?? 'Browse our collection of high-quality products in this category.' }}
                </p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Filters - 1/4 width on large screens -->
            <div class="lg:col-span-1">
                <form id="filter-form" action="{{ route('products.category', $category['category_id']) }}" method="GET" class="bg-white p-6 rounded-xl shadow-sm mb-6 border border-gray-100 sticky top-24">
                    <h2 class="text-lg font-bold mb-4 pb-2 border-b">Filters</h2>
                    
                    <!-- Category Filter -->
                    <div class="mb-6">
                        <h3 class="font-medium mb-3">Categories</h3>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="radio" id="all-categories" name="category" value="" class="text-primary-600 focus:ring-primary-500">
                                <label for="all-categories" class="ml-2 text-gray-700 hover:text-primary-600 cursor-pointer">All Categories</label>
                            </div>
                            
                            @if(isset($categories) && count($categories) > 0)
                                @foreach($categories as $cat)
                                    <div class="flex items-center">
                                        <input type="radio" id="category-{{ $cat['category_id'] }}" name="category" value="{{ $cat['category_id'] }}" {{ isset($category) && $category['category_id'] == $cat['category_id'] ? 'checked' : '' }} class="text-primary-600 focus:ring-primary-500">
                                        <label for="category-{{ $cat['category_id'] }}" class="ml-2 text-gray-700 hover:text-primary-600 cursor-pointer">{{ $cat['category_name'] }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    
                    <!-- Price Range Filter -->
                    <div class="mb-6">
                        <h3 class="font-medium mb-3">Price Range</h3>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="radio" id="price-all" name="price" value="" {{ empty($priceRange) ? 'checked' : '' }} class="text-primary-600 focus:ring-primary-500">
                                <label for="price-all" class="ml-2 text-gray-700 hover:text-primary-600 cursor-pointer">All Prices</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="price-under-50" name="price" value="under-50" {{ $priceRange == 'under-50' ? 'checked' : '' }} class="text-primary-600 focus:ring-primary-500">
                                <label for="price-under-50" class="ml-2 text-gray-700 hover:text-primary-600 cursor-pointer">Under $50</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="price-50-100" name="price" value="50-100" {{ $priceRange == '50-100' ? 'checked' : '' }} class="text-primary-600 focus:ring-primary-500">
                                <label for="price-50-100" class="ml-2 text-gray-700 hover:text-primary-600 cursor-pointer">$50 - $100</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="price-100-plus" name="price" value="100-plus" {{ $priceRange == '100-plus' ? 'checked' : '' }} class="text-primary-600 focus:ring-primary-500">
                                <label for="price-100-plus" class="ml-2 text-gray-700 hover:text-primary-600 cursor-pointer">$100 & Above</label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Custom Price Range -->
                    <div class="mb-6">
                        <h3 class="font-medium mb-3">Custom Price</h3>
                        <div class="flex items-center space-x-2">
                            <div class="relative flex-1">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">$</span>
                                <input type="number" name="min_price" id="min-price" placeholder="Min" min="0" value="{{ $minPrice ?? '' }}" class="pl-7 w-full border rounded-md p-2 focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                            <span class="text-gray-500">-</span>
                            <div class="relative flex-1">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">$</span>
                                <input type="number" name="max_price" id="max-price" placeholder="Max" min="0" value="{{ $maxPrice ?? '' }}" class="pl-7 w-full border rounded-md p-2 focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Apply Filters Button -->
                    <button type="submit" class="w-full bg-primary-600 text-white py-3 rounded-lg hover:bg-primary-700 transition shadow hover:shadow-md transform hover:-translate-y-0.5">
                        Apply Filters
                    </button>

                    @if($priceRange || isset($minPrice) || isset($maxPrice))
                    <a href="{{ route('products.category', $category['category_id']) }}" class="mt-3 block text-center w-full text-primary-600 py-2 border border-primary-600 rounded-lg hover:bg-primary-50 transition">
                        Clear Filters
                    </a>
                    @endif
                </form>
            </div>
            
            <!-- Products Grid - 3/4 width on large screens -->
            <div class="lg:col-span-3">
                <!-- Sort & View Controls -->
                <div class="bg-white p-5 rounded-xl shadow-sm mb-6 flex flex-col sm:flex-row justify-between items-center border border-gray-100">
                    <div class="mb-4 sm:mb-0 w-full sm:w-auto">
                        <label for="sort-options" class="text-gray-600 mr-2">Sort by:</label>
                        <select id="sort-options" class="border rounded-md p-2 focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                            <option value="name-asc">Name (A-Z)</option>
                            <option value="name-desc">Name (Z-A)</option>
                            <option value="price-asc">Price (Low to High)</option>
                            <option value="price-desc">Price (High to Low)</option>
                        </select>
                    </div>
                    
                    <div class="flex items-center">
                        <span class="text-gray-600 mr-2">View:</span>
                        <button class="p-2 text-primary-600 hover:text-primary-800 focus:outline-none" title="Grid View">
                            <i class="fas fa-th"></i>
                        </button>
                        <button class="p-2 text-gray-400 hover:text-primary-600 focus:outline-none" title="List View">
                            <i class="fas fa-list"></i>
                        </button>
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
                                        
                                                                                <div class="absolute top-0 right-0 mt-3 mr-3 transform transition hover:scale-110">                                            <button class="wishlist-button bg-white text-gray-700 hover:text-primary-600 p-2 rounded-full shadow-md transition"                                                   data-product-id="{{ $product['product_id'] }}">                                                <i class="far fa-heart"></i>                                            </button>                                        </div>
                                    </div>
                                </a>
                                
                                <div class="product-info">
                                    <a href="{{ route('products.show', $product['product_id']) }}" class="block">
                                        <h3 class="product-title line-clamp-1">{{ $product['product_name'] }}</h3>
                                    </a>
                                    
                                    <p class="product-description line-clamp-2">
                                        {{ \Illuminate\Support\Str::limit($product['product_description'], 100) }}
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
                    <div class="bg-white rounded-xl shadow-sm p-12 text-center border border-gray-100">
                        <div class="max-w-md mx-auto">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-6">
                                <i class="fas fa-box-open text-3xl text-gray-400"></i>
                            </div>
                            <h2 class="text-2xl font-bold mb-2">No products found</h2>
                            <p class="text-gray-600 mb-6">We couldn't find any products in this category.</p>
                            <a href="{{ route('products.index') }}" class="bg-primary-600 text-white font-medium px-6 py-3 rounded-lg hover:bg-primary-700 inline-block transition shadow-sm hover:shadow-md">
                                Browse All Products
                            </a>
                        </div>
                    </div>
                @endif
                
                <!-- Pagination -->
                <div class="mt-10 flex justify-center">
                    <nav class="relative z-0 inline-flex rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <a href="#" class="relative inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-primary-600 border-r border-gray-200">
                            <span class="sr-only">Previous</span>
                            <i class="fas fa-chevron-left text-xs"></i>
                        </a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 bg-primary-600 text-sm font-medium text-white hover:bg-primary-700 border-r border-primary-700">
                            1
                        </a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-primary-600 border-r border-gray-200">
                            2
                        </a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-primary-600 border-r border-gray-200">
                            3
                        </a>
                        <span class="relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-700 border-r border-gray-200">
                            ...
                        </span>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-primary-600 border-r border-gray-200">
                            8
                        </a>
                        <a href="#" class="relative inline-flex items-center px-3 py-2 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-primary-600">
                            <span class="sr-only">Next</span>
                            <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Category filter functionality
    document.querySelectorAll('input[name="category"]').forEach(input => {
        input.addEventListener('change', function() {
            if (this.value) {
                window.location.href = "{{ url('category') }}/" + this.value;
            } else {
                window.location.href = "{{ route('products.index') }}";
            }
        });
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
    
    // Sort functionality would typically be handled with backend logic
    document.getElementById('sort-options').addEventListener('change', function() {
        // In a real application, you would redirect to the server with the sort parameter
        // or use JavaScript to sort the items on the page
        console.log('Sort option selected:', this.value);
    });
</script>
@endsection 