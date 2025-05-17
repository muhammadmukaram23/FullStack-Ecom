@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
        <nav class="text-sm mb-8">
            <ol class="list-none p-0 flex flex-wrap items-center">
                <li class="flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary-600">Home</a>
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                </li>
                <li class="text-gray-700 font-medium">Shopping Cart</li>
            </ol>
        </nav>

        <h1 class="text-3xl font-bold mb-8">Your Cart</h1>
        
        @if(isset($items) && count($items) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items - 2/3 width on large screens -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
                        <div class="p-6">
                            <!-- Cart Headers (Desktop) -->
                            <div class="hidden md:grid md:grid-cols-12 pb-3 border-b text-gray-500 text-sm font-medium">
                                <div class="md:col-span-6">Product</div>
                                <div class="md:col-span-2 text-center">Price</div>
                                <div class="md:col-span-2 text-center">Quantity</div>
                                <div class="md:col-span-2 text-right">Total</div>
                            </div>
                            
                            <!-- Cart Items -->
                            <div class="divide-y">
                                @foreach($items as $item)
                                    <div class="py-6 md:grid md:grid-cols-12 md:gap-6 md:items-center relative">
                                        <!-- Product -->
                                        <div class="md:col-span-6">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 mr-4">
                                                    @if(isset($item['product']['images']) && count($item['product']['images']) > 0)
                                                        <img src="{{ $item['product']['images'][0]['image_url'] }}" alt="{{ $item['product']['product_name'] }}" class="w-20 h-20 object-cover rounded-lg">
                                                    @else
                                                        <img src="https://via.placeholder.com/80x80" alt="{{ $item['product']['product_name'] }}" class="w-20 h-20 object-cover rounded-lg">
                                                    @endif
                                                </div>
                                                <div>
                                                    <a href="{{ route('products.show', $item['product']['product_id']) }}" class="font-medium text-gray-800 hover:text-primary-600 block mb-1">
                                                        {{ $item['product']['product_name'] }}
                                                    </a>
                                                    <div class="text-gray-500 text-sm mb-1">Product ID: {{ $item['product']['product_id'] }}</div>
                                                    
                                                    <!-- Mobile Price -->
                                                    <div class="md:hidden text-gray-700 mt-2">
                                                        <span class="font-medium">${{ number_format($item['product']['product_price'], 2) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Price (Desktop) -->
                                        <div class="hidden md:block md:col-span-2 text-center text-gray-700 font-medium">
                                            ${{ number_format($item['product']['product_price'], 2) }}
                                        </div>
                                        
                                        <!-- Quantity -->
                                        <div class="md:col-span-2 mt-4 md:mt-0">
                                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="md:flex md:justify-center">
                                                @csrf
                                                @method('PUT')
                                                <div class="flex border rounded-md max-w-[120px] h-10">
                                                    <button type="button" onclick="decrementQty(this)" class="w-10 flex items-center justify-center bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-l-md">
                                                        <i class="fas fa-minus text-xs"></i>
                                                    </button>
                                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-full text-center focus:outline-none focus:ring-0 focus:border-gray-300 text-gray-700" onchange="this.form.submit()">
                                                    <button type="button" onclick="incrementQty(this)" class="w-10 flex items-center justify-center bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-r-md">
                                                        <i class="fas fa-plus text-xs"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        
                                        <!-- Total -->
                                        <div class="md:col-span-2 mt-4 md:mt-0 flex md:justify-end items-center justify-between">
                                            <span class="md:hidden font-medium">Total:</span>
                                            <span class="font-medium text-gray-900">${{ number_format($item['product']['product_price'] * $item['quantity'], 2) }}</span>
                                        </div>
                                        
                                        <!-- Remove Button (Mobile) -->
                                        <div class="mt-4 md:hidden">
                                            <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-yellow-600 hover:text-yellow-800 flex items-center">
                                                    <i class="fas fa-trash mr-1"></i> Remove
                                                </button>
                                            </form>
                                        </div>
                                        
                                        <!-- Remove Button (Desktop) -->
                                        <div class="hidden md:block absolute top-6 right-0">
                                            <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600 transition p-2">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <!-- Continue Shopping Button -->
                    <div class="flex items-center justify-between mb-6">
                        <a href="{{ route('products.index') }}" class="text-yellow-600 hover:text-yellow-800 flex items-center font-medium">
                            <i class="fas fa-arrow-left mr-2"></i> Continue Shopping
                        </a>
                    </div>
                </div>
                
                <!-- Order Summary - 1/3 width on large screens -->
                <div>
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden sticky top-24">
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-6">Order Summary</h2>
                            
                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium">${{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-medium">$200.00</span>
                                </div>
                                
                                <div class="border-t border-gray-200 pt-4 mt-4">
                                    <div class="flex justify-between font-bold text-lg">
                                        <span>Total</span>
                                        <span>${{ number_format($total + 200, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Promo Code Section -->
                            <div class="mb-6">
                                <label for="promo-code" class="block text-sm font-medium text-gray-700 mb-2">Promo Code</label>
                                <div class="flex">
                                    <input type="text" id="promo-code" class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                    <button class="bg-gray-800 text-white font-medium px-4 py-2 rounded-r-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-opacity-50">
                                        Apply
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Checkout Button -->
                            <a href="{{ route('checkout') }}" class="block w-full py-3 px-4 rounded-md shadow bg-yellow-600 text-white font-medium hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 text-center">
                                Proceed to Checkout
                            </a>
                            
                            <!-- Payment Methods -->
                            <div class="mt-6">
                                <p class="text-gray-500 text-sm text-center mb-3">Secure Payment Methods</p>
                                <div class="flex justify-center space-x-2">
                                    <i class="fab fa-cc-visa text-gray-400 text-2xl"></i>
                                    <i class="fab fa-cc-mastercard text-gray-400 text-2xl"></i>
                                    <i class="fab fa-cc-amex text-gray-400 text-2xl"></i>
                                    <i class="fab fa-cc-paypal text-gray-400 text-2xl"></i>
                                    <i class="fab fa-cc-apple-pay text-gray-400 text-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                <div class="max-w-md mx-auto">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-6">
                        <i class="fas fa-shopping-cart text-3xl text-gray-400"></i>
                    </div>
                    <h2 class="text-2xl font-bold mb-3">Your cart is empty</h2>
                    <p class="text-gray-600 mb-8">It looks like you haven't added any products to your cart yet.</p>
                    <a href="{{ route('products.index') }}" class="inline-block bg-yellow-600 text-white font-medium px-8 py-3 rounded-md hover:bg-yellow-700 transition shadow-sm">
                        Browse Products
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
    function incrementQty(button) {
        const input = button.previousElementSibling;
        input.value = parseInt(input.value) + 1;
        // Automatically submit the form
        button.closest('form').submit();
    }
    
    function decrementQty(button) {
        const input = button.nextElementSibling;
        const currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
            // Automatically submit the form
            button.closest('form').submit();
        }
    }
</script>
@endsection 