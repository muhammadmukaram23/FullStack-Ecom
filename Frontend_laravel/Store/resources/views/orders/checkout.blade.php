@extends('layouts.app')

@section('title', 'Checkout')

@php
use Illuminate\Support\Facades\Session;
@endphp

@section('content')
    <h1 class="text-3xl font-bold mb-6">Checkout</h1>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Checkout Form - 2/3 width on large screens -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <form action="{{ route('order.place') }}" method="POST">
                        @csrf
                        
                        <!-- Shipping Information -->
                        <div class="mb-6">
                            <h2 class="text-xl font-bold mb-4">Shipping Information</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="first_name" class="block text-gray-700 font-medium mb-2">First Name</label>
                                    <input type="text" id="first_name" name="first_name" required 
                                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600">
                                </div>
                                <div>
                                    <label for="last_name" class="block text-gray-700 font-medium mb-2">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" required 
                                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                                <input type="email" id="email" name="email" value="{{ Session::get('user.user_email') }}" required 
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600">
                            </div>
                            
                            <div class="mb-4">
                                <label for="phone" class="block text-gray-700 font-medium mb-2">Phone Number</label>
                                <input type="tel" id="phone" name="phone" required 
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600">
                            </div>
                            
                            <div class="mb-4">
                                <label for="address" class="block text-gray-700 font-medium mb-2">Street Address</label>
                                <input type="text" id="address" name="address" required 
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600 @error('address') border-red-500 @enderror">
                                
                                @error('address')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="city" class="block text-gray-700 font-medium mb-2">City</label>
                                    <select id="city" name="city" required 
                                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600">
                                        <option value="">Select City</option>
                                        <option value="Karachi">Karachi</option>
                                        <option value="Lahore">Lahore</option>
                                        <option value="Kotla Qasim Khan">Kotla Qasim Khan</option>
                                        <option value="Faisalabad">Faisalabad</option>
                                        <option value="Rawalpindi">Rawalpindi</option>
                                        <option value="Gujranwala">Gujranwala</option>
                                        <option value="Peshawar">Peshawar</option>
                                        <option value="Multan">Multan</option>
                                        <option value="Hyderabad City">Hyderabad City</option>
                                        <option value="Islamabad">Islamabad</option>
                                        <option value="Quetta">Quetta</option>
                                        <option value="Cantonment">Cantonment</option>
                                        <option value="Eminabad">Eminabad</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="state" class="block text-gray-700 font-medium mb-2">Province</label>
                                    <select id="state" name="state" required 
                                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600">
                                        <option value="">Select Province</option>
                                        <option value="Punjab">Punjab</option>
                                        <option value="Sindh">Sindh</option>
                                        <option value="KPK">KPK</option>
                                        <option value="Balochistan">Balochistan</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="zip" class="block text-gray-700 font-medium mb-2">Zip Code</label>
                                    <input type="text" id="zip" name="zip" required 
                                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment Method -->
                        <div class="mb-6">
                            <h2 class="text-xl font-bold mb-4">Payment Method</h2>
                            
                            <div class="mb-4">
                                <div class="flex items-center mb-2">
                                    <input type="radio" id="payment_cash" name="payment_method" value="cash_on_delivery" checked
                                        class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300">
                                    <label for="payment_cash" class="ml-2 block text-gray-700">Cash on Delivery</label>
                                </div>
                                <p class="text-gray-500 text-sm ml-6">Pay with cash when your order is delivered.</p>
                            </div>
                            
                            <div>
                                <div class="flex items-center mb-2 opacity-50">
                                    <input type="radio" id="payment_card" name="payment_method" value="credit_card" disabled
                                        class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300">
                                    <label for="payment_card" class="ml-2 block text-gray-700">Credit/Debit Card</label>
                                </div>
                                <p class="text-gray-500 text-sm ml-6">Currently unavailable. Only Cash on Delivery is supported.</p>
                            </div>
                        </div>
                        
                        <div class="border-t pt-6">
                            <button type="submit" class="bg-yellow-600 text-white font-medium py-3 px-6 rounded-md hover:bg-yellow-700 transition">
                                Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Order Summary - 1/3 width on large screens -->
        <div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden sticky top-4">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                    
                    <div class="border-b pb-4 mb-4">
                        @if(isset($items) && count($items) > 0)
                            @foreach($items as $item)
                                <div class="flex justify-between items-center mb-3">
                                    <div class="flex items-center">
                                        <span class="bg-gray-200 text-gray-700 w-6 h-6 rounded-full flex items-center justify-center mr-2">
                                            {{ $item['quantity'] }}
                                        </span>
                                        <span>{{ $item['product']['product_name'] }}</span>
                                    </div>
                                    <span>${{ number_format($item['product']['product_price'] * $item['quantity'], 2) }}</span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    
                    <div class="border-b pb-4 mb-4">
                        <div class="flex justify-between mb-2">
                            <span>Subtotal</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span>Shipping</span>
                            <span>${{ number_format($shipping, 2) }}</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="font-bold">Total</span>
                        <span class="font-bold">${{ number_format($grandTotal, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 