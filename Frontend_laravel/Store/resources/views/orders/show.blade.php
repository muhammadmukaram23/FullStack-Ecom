@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold">Order #{{ $order['order_id'] ?? 'N/A' }}</h1>
        <a href="{{ route('orders.index') }}" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-1"></i> Back to Orders
        </a>
    </div>
    
    @if(isset($order))
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Order Details - 2/3 width on large screens -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="p-6">
                        <h2 class="text-xl font-bold mb-4">Order Status</h2>
                        
                        <div class="mb-6">
                            <div class="flex items-center mb-2">
                                <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                    {{ $order['status'] ?? 'Processing' }}
                                </span>
                                <span class="text-gray-500 ml-3">{{ date('M d, Y h:i A', strtotime($order['order_date'])) }}</span>
                            </div>
                            <p class="text-gray-600">
                                Your order has been received and is being processed. You will be notified when your order ships.
                            </p>
                        </div>
                        
                        <h2 class="text-xl font-bold mb-4">Order Items</h2>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b">
                                        <th class="text-left pb-4">Product</th>
                                        <th class="text-center pb-4">Quantity</th>
                                        <th class="text-right pb-4">Price</th>
                                        <th class="text-right pb-4">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($order['items']) && count($order['items']) > 0)
                                        @foreach($order['items'] as $item)
                                            <tr class="border-b py-4">
                                                <td class="py-4">
                                                    <div class="flex items-center">
                                                        @if(isset($item['product']['images']) && count($item['product']['images']) > 0)
                                                            <img src="{{ $item['product']['images'][0]['image_url'] }}" alt="{{ $item['product']['product_name'] ?? 'Product' }}" class="w-16 h-16 object-cover rounded mr-4">
                                                        @else
                                                            <img src="https://via.placeholder.com/80x80" alt="{{ $item['product']['product_name'] ?? 'Product' }}" class="w-16 h-16 object-cover rounded mr-4">
                                                        @endif
                                                        <span>{{ $item['product']['product_name'] ?? 'Product' }}</span>
                                                    </div>
                                                </td>
                                                <td class="py-4 text-center">{{ $item['quantity'] ?? 1 }}</td>
                                                <td class="py-4 text-right">${{ number_format($item['product']['product_price'] ?? 0, 2) }}</td>
                                                <td class="py-4 text-right">${{ number_format(($item['product']['product_price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="py-4 text-center text-gray-500">No items in this order</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-bold mb-4">Shipping Information</h2>
                        
                        <div class="mb-4">
                            <h3 class="font-medium text-gray-700 mb-2">Shipping Address</h3>
                            <p class="text-gray-600">{{ $order['user_address'] ?? 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <h3 class="font-medium text-gray-700 mb-2">Shipping Method</h3>
                            <p class="text-gray-600">Standard Shipping</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary - 1/3 width on large screens -->
            <div>
                <div class="bg-white rounded-lg shadow-md overflow-hidden sticky top-4">
                    <div class="p-6">
                        <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                        
                        <div class="border-b pb-4 mb-4">
                            <div class="flex justify-between mb-2">
                                <span>Subtotal</span>
                                <span>${{ number_format($order['subtotal'] ?? ($order['total_amount'] ?? 0) / 1.1, 2) }}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span>Shipping</span>
                                <span>${{ number_format($order['shipping'] ?? 200.00, 2) }}</span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between mb-6">
                            <span class="font-bold">Total</span>
                            <span class="font-bold">${{ number_format($order['total_amount'] ?? 0, 2) }}</span>
                        </div>
                        
                        <div class="border-t pt-4">
                            <h3 class="font-medium text-gray-700 mb-2">Payment Method</h3>
                            <p class="text-gray-600">{{ $order['payment_method'] ?? 'Cash on Delivery' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <div class="text-gray-500 mb-6">
                <i class="fas fa-exclamation-circle text-6xl mb-4"></i>
                <h2 class="text-2xl font-bold mb-2">Order Not Found</h2>
                <p>We couldn't find the order you're looking for.</p>
            </div>
            <a href="{{ route('orders.index') }}" class="bg-blue-600 text-white font-medium px-6 py-3 rounded-md hover:bg-blue-700 inline-block">
                View All Orders
            </a>
        </div>
    @endif
@endsection 