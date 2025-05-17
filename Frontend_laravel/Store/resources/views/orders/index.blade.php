@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <h1 class="text-3xl font-bold mb-6">My Orders</h1>
    
    @if(isset($orders) && count($orders) > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-3 text-left">Order ID</th>
                            <th class="py-3 text-left">Date</th>
                            <th class="py-3 text-left hidden md:table-cell">Shipping Address</th>
                            <th class="py-3 text-right">Total</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4">{{ $order['order_id'] }}</td>
                                <td class="py-4">{{ date('M d, Y', strtotime($order['order_date'])) }}</td>
                                <td class="py-4 hidden md:table-cell">
                                    {{ \Illuminate\Support\Str::limit($order['user_address'], 50) }}
                                </td>
                                <td class="py-4 text-right">
                                    
                                    ${{ number_format($order['total_amount'] ?? 0, 2) }}
                                  
                                </td>
                                <td class="py-4 text-center">
                                    <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded text-xs">
                                        {{ $order['status'] ?? 'Processing' }}
                                    </span>
                                </td>
                                <td class="py-4 text-right">
                                    <a href="{{ route('orders.show', $order['order_id']) }}" class="text-blue-600 hover:text-blue-800">
                                        View <i class="fas fa-arrow-right text-xs ml-1"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <div class="text-gray-500 mb-6">
                <i class="fas fa-shopping-bag text-6xl mb-4"></i>
                <h2 class="text-2xl font-bold mb-2">No orders yet</h2>
                <p>You haven't placed any orders yet. Start shopping to place your first order!</p>
            </div>
            <a href="{{ route('products.index') }}" class="bg-blue-600 text-white font-medium px-6 py-3 rounded-md hover:bg-blue-700 inline-block">
                Browse Products
            </a>
        </div>
    @endif
@endsection 