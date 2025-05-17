@extends('layouts.admin')

@section('title', 'Order Details')
@section('subtitle', 'View details for order #' . $order['order_id'])

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.orders') }}" class="text-blue-700 hover:text-blue-900">
            <i class="fas fa-arrow-left mr-1"></i> Back to Orders
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Information -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-800">Order Information</h2>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <p class="text-sm text-gray-600">Order ID</p>
                        <p class="font-semibold">#{{ $order['order_id'] }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-600">Date</p>
                        <p class="font-semibold">{{ \Carbon\Carbon::parse($order['order_date'])->format('M d, Y h:i A') }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-600">Shipping Address</p>
                        <p class="font-semibold">{{ $order['user_address'] }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mt-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-800">Items</h2>
                </div>
                <div class="p-6">
                    @if(isset($order['cart']) && isset($order['cart']['cart_items']) && count($order['cart']['cart_items']) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Product
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Quantity
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Price
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php
                                        $subtotal = 0;
                                    @endphp
                                    @foreach($order['cart']['cart_items'] as $item)
                                        @php
                                            $itemTotal = $item['product']['product_price'] * $item['quantity'];
                                            $subtotal += $itemTotal;
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    @if(isset($item['product']['images']) && count($item['product']['images']) > 0)
                                                        <div class="flex-shrink-0 h-16 w-16">
                                                            <img class="h-16 w-16 rounded object-cover" src="{{ $item['product']['images'][0]['image_url'] }}" alt="{{ $item['product']['product_name'] }}">
                                                        </div>
                                                    @else
                                                        <div class="flex-shrink-0 h-16 w-16 bg-gray-200 rounded flex items-center justify-center">
                                                            <i class="fas fa-image text-gray-400"></i>
                                                        </div>
                                                    @endif
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $item['product']['product_name'] }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            Category: {{ $item['product']['category']['category_name'] ?? 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $item['quantity'] }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                ${{ number_format($item['product']['product_price'], 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                ${{ number_format($itemTotal, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <p class="text-gray-500">No items found in this order</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Customer Information and Order Summary -->
        <div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-800">Customer</h2>
                </div>
                <div class="p-6">
                    @if(isset($order['user_details']))
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-100 rounded-full p-3 text-blue-500">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium">{{ $order['user_details']['user_name'] }}</h3>
                                <p class="text-gray-600">{{ $order['user_details']['user_email'] }}</p>
                            </div>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-600">Customer ID</p>
                            <p class="font-semibold">{{ $order['user_id'] }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-600">Age</p>
                            <p class="font-semibold">{{ $order['user_details']['user_age'] ?? 'N/A' }}</p>
                        </div>
                    @else
                        <div class="mb-4">
                            <p class="text-sm text-gray-600">Customer ID</p>
                            <p class="font-semibold">{{ $order['user_id'] }}</p>
                        </div>
                    @endif
                </div>
            </div>
            
            @if(isset($order['cart']) && isset($order['cart']['cart_items']) && count($order['cart']['cart_items']) > 0)
                @php
                    $subtotal = 0;
                    $shipping = 200.00; // Fixed shipping fee
                    
                    // Calculate subtotal from cart items
                    foreach($order['cart']['cart_items'] as $item) {
                        $itemTotal = $item['product']['product_price'] * $item['quantity'];
                        $subtotal += $itemTotal;
                    }
                    
                    $total = $subtotal + $shipping; // Calculate total with shipping
                @endphp
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-800">Order Summary</h2>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Subtotal</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Shipping</span>
                            <span>${{ number_format($shipping, 2) }}</span>
                        </div>
                        <div class="border-t mt-3 pt-3">
                            <div class="flex justify-between font-bold">
                                <span>Total</span>
                                <span>${{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection 