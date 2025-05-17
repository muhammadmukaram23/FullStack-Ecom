@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Search Results for "{{ $searchQuery }}"</h1>
            <p class="text-gray-600">Found {{ count($products) }} product(s) matching your search.</p>
        </div>

        <!-- Search Results -->
        @if(count($products) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden card-hover">
                        <a href="{{ route('products.show', $product['product_id']) }}">
                            <div class="h-48 overflow-hidden bg-gray-200">
                                @if(isset($product['product_images']) && count($product['product_images']) > 0)
                                    <img src="{{ $product['product_images'][0]['image_url'] }}" alt="{{ $product['product_name'] }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                        <i class="fas fa-image text-gray-400 text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $product['product_name'] }}</h3>
                                <p class="text-gray-600 text-sm mb-2 line-clamp-2">{{ \Illuminate\Support\Str::limit($product['product_description'] ?? '', 100) }}</p>
                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-primary-600 font-bold">${{ number_format($product['product_price'], 2) }}</span>
                                    <button 
                                        onclick="event.preventDefault(); document.getElementById('add-to-cart-{{ $product['product_id'] }}').submit();" 
                                        class="bg-primary-500 hover:bg-primary-600 text-white px-3 py-1 rounded-full text-sm transition"
                                    >
                                        Add to Cart
                                    </button>
                                    <form id="add-to-cart-{{ $product['product_id'] }}" action="{{ route('cart.add') }}" method="POST" class="hidden">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product['product_id'] }}">
                                        <input type="hidden" name="quantity" value="1">
                                    </form>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="inline-flex rounded-full bg-gray-100 p-6 mb-6">
                    <i class="fas fa-search text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">No products found</h3>
                <p class="text-gray-600 mb-6">We couldn't find any products matching "{{ $searchQuery }}".</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition">
                    Browse All Products
                </a>
            </div>
        @endif
    </div>
@endsection 