@extends('layouts.admin')

@section('title', 'Orders')
@section('subtitle', 'Manage customer orders')

@section('content')
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if(isset($orders) && count($orders) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order ID
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Sample Product
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $order['order_id'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($order['order_date'])->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if(isset($order['user_details']))
                                        {{ $order['user_details']['user_name'] }}
                                    @else
                                        Customer ID: {{ $order['user_id'] }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if(isset($order['cart']) && isset($order['cart']['cart_items']) && count($order['cart']['cart_items']) > 0)
                                        <div class="flex items-center">
                                            @php
                                                $firstItem = $order['cart']['cart_items'][0];
                                                $product = $firstItem['product'] ?? null;
                                            @endphp
                                            @if($product && isset($product['images']) && count($product['images']) > 0)
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $product['images'][0]['image_url'] }}" alt="{{ $product['product_name'] }}">
                                                <span class="ml-2">{{ $product['product_name'] }}</span>
                                            @else
                                                <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-image text-gray-400"></i>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.orders.view', $order['order_id']) }}" class="text-blue-600 hover:text-blue-900">View Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-8 text-center">
                <div class="mb-4 text-gray-500">
                    <i class="fas fa-shopping-bag text-5xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">No orders found</h3>
                <p class="text-gray-500">Orders will appear here when customers make purchases.</p>
            </div>
        @endif
    </div>
@endsection 