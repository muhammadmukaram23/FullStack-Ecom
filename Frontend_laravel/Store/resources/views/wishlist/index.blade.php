@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-8">My Wishlist</h1>
    
    @if(count($products) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 card-hover relative">
                    <form action="{{ route('wishlist.remove', $product['product_id']) }}" method="POST" class="absolute top-2 right-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-white text-red-500 hover:text-red-700 p-2 rounded-full shadow-sm transition-colors">
                            <i class="fas fa-heart"></i>
                        </button>
                    </form>
                    
                    <a href="{{ route('products.show', $product['product_id']) }}">
                        <div class="h-48 overflow-hidden">
                            @if(isset($product['images']) && count($product['images']) > 0)
                                <img src="{{ $product['images'][0]['image_url'] }}" alt="{{ $product['product_name'] }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://via.placeholder.com/300" alt="{{ $product['product_name'] }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                    </a>
                    
                    <div class="p-4">
                        <a href="{{ route('products.show', $product['product_id']) }}" class="block">
                            <h3 class="font-semibold hover:text-yellow-600 transition">{{ $product['product_name'] }}</h3>
                        </a>
                        <p class="text-gray-700 font-bold mt-2">${{ number_format($product['product_price'], 2) }}</p>
                        
                        <div class="mt-4 flex space-x-2">
                            <form action="{{ route('cart.add') }}" method="POST" class="flex-grow">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product['product_id'] }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white w-full py-2 rounded-md text-sm font-medium transition">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-5xl text-gray-300 mb-4"><i class="far fa-heart"></i></div>
            <h2 class="text-xl font-medium text-gray-600 mb-2">Your wishlist is empty</h2>
            <p class="text-gray-500 mb-6">Start adding products you love to your wishlist</p>
            <a href="{{ route('products.index') }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-md text-sm font-medium inline-block transition">
                Browse Products
            </a>
        </div>
    @endif
</div>
@endsection 