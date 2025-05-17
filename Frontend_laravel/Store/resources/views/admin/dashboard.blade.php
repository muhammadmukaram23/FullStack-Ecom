@extends('layouts.admin')

@section('title', 'Dashboard')
@section('subtitle', 'Overview of your store performance')

@section('styles')
    <style>
        .stat-card {
            transition: all 0.3s ease;
            border-radius: 1rem;
            overflow: hidden;
            position: relative;
            z-index: 1;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right bottom, rgba(255,255,255,0.1), rgba(255,255,255,0));
            z-index: -1;
        }
        
        .card-gradient-1 {
            background: linear-gradient(120deg, #4f46e5, #7c3aed);
        }
        
        .card-gradient-2 {
            background: linear-gradient(120deg, #059669, #34d399);
        }
        
        .card-gradient-3 {
            background: linear-gradient(120deg, #d97706, #fbbf24);
        }
        
        .card-gradient-4 {
            background: linear-gradient(120deg, #dc2626, #f87171);
        }
        
        .card-gradient-5 {
            background: linear-gradient(120deg, #7c3aed, #a78bfa);
        }
        
        .content-card {
            transition: all 0.2s ease;
            border-radius: 1rem;
            border: 1px solid #f3f4f6;
        }
        
        .content-card:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            border-color: #e5e7eb;
        }
        
        .table-container {
            border-radius: 0.75rem;
            overflow: hidden;
        }
        
        .table-responsive {
            overflow-x: auto;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f8fafc;
        }
        
        .table-responsive::-webkit-scrollbar {
            height: 6px;
        }
        
        .table-responsive::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        
        .table-responsive::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }
    </style>
@endsection

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <!-- Products Stat -->
        <div class="stat-card shadow">
            <div class="card-gradient-1 text-white p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-white/80 text-sm font-medium uppercase tracking-wider">Products</p>
                        <h2 class="text-3xl font-bold mt-2">{{ $stats['products'] ?? 0 }}</h2>
                    </div>
                    <div class="rounded-full bg-white/20 p-3">
                        <i class="fas fa-box text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <a href="{{ route('admin.products') }}" class="flex items-center text-white/90 text-sm hover:text-white">
                        View all products <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Categories Stat -->
        <div class="stat-card shadow">
            <div class="card-gradient-2 text-white p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-white/80 text-sm font-medium uppercase tracking-wider">Categories</p>
                        <h2 class="text-3xl font-bold mt-2">{{ $stats['categories'] ?? 0 }}</h2>
                    </div>
                    <div class="rounded-full bg-white/20 p-3">
                        <i class="fas fa-tags text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <a href="{{ route('admin.categories') }}" class="flex items-center text-white/90 text-sm hover:text-white">
                        View all categories <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Orders Stat -->
        <div class="stat-card shadow">
            <div class="card-gradient-3 text-white p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-white/80 text-sm font-medium uppercase tracking-wider">Orders</p>
                        <h2 class="text-3xl font-bold mt-2">{{ $stats['orders'] ?? 0 }}</h2>
                    </div>
                    <div class="rounded-full bg-white/20 p-3">
                        <i class="fas fa-shopping-bag text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <a href="{{ route('admin.orders') }}" class="flex items-center text-white/90 text-sm hover:text-white">
                        View all orders <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Users Stat -->
        <div class="stat-card shadow">
            <div class="card-gradient-4 text-white p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-white/80 text-sm font-medium uppercase tracking-wider">Users</p>
                        <h2 class="text-3xl font-bold mt-2">{{ $stats['users'] ?? 0 }}</h2>
                    </div>
                    <div class="rounded-full bg-white/20 p-3">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <a href="{{ route('admin.users') }}" class="flex items-center text-white/90 text-sm hover:text-white">
                        View all users <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Total Sales Stat -->
        <div class="stat-card shadow">
            <div class="card-gradient-5 text-white p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-white/80 text-sm font-medium uppercase tracking-wider">Total Sales</p>
                        <h2 class="text-3xl font-bold mt-2">${{ number_format($stats['total_sales'] ?? 0, 2) }}</h2>
                    </div>
                    <div class="rounded-full bg-white/20 p-3">
                        <i class="fas fa-dollar-sign text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <a href="{{ route('admin.orders') }}" class="flex items-center text-white/90 text-sm hover:text-white">
                        View all orders <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content Cards -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">
        <!-- Recent Products -->
        <div class="content-card bg-white shadow-sm overflow-hidden">
            <div class="flex justify-between items-center p-6 border-b">
                <div class="flex items-center">
                    <div class="rounded-full bg-blue-100 p-2 mr-3">
                        <i class="fas fa-box text-blue-600"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-800">Recent Products</h2>
                </div>
                <a href="{{ route('admin.products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition flex items-center text-sm font-medium">
                    <i class="fas fa-plus mr-1"></i> Add New
                </a>
            </div>
            
            @if(isset($products) && count($products) > 0)
                <div class="table-responsive">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($products as $product)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if(isset($product['images']) && count($product['images']) > 0)
                                                <div class="flex-shrink-0 h-10 w-10 mr-3">
                                                    <img class="h-10 w-10 rounded-lg object-cover shadow-sm" src="{{ $product['images'][0]['image_url'] ?? '' }}" alt="{{ $product['product_name'] }}">
                                                </div>
                                            @else
                                                <div class="flex-shrink-0 h-10 w-10 mr-3 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-image text-gray-400"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $product['product_name'] }}</div>
                                                <div class="text-xs text-gray-500 truncate max-w-xs">{{ \Illuminate\Support\Str::limit($product['product_description'] ?? '', 60) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">${{ number_format($product['product_price'], 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('admin.products.edit', $product['product_id']) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="text-red-600 hover:text-red-900" 
                                           onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this product?')) document.getElementById('delete-product-{{ $product['product_id'] }}').submit();">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <form id="delete-product-{{ $product['product_id'] }}" action="{{ route('admin.products.delete', $product['product_id']) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-6 text-center">
                    <div class="inline-flex rounded-full bg-gray-100 p-4 mb-4">
                        <i class="fas fa-box text-gray-500 text-xl"></i>
                    </div>
                    <p class="text-gray-500 mb-4">No products found</p>
                    <a href="{{ route('admin.products.create') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition">
                        Add your first product
                    </a>
                </div>
            @endif
        </div>
        
        <!-- Recent Orders -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="flex justify-between items-center p-6 border-b">
                <h2 class="text-xl font-bold text-gray-800">Recent Orders</h2>
                <a href="{{ route('admin.orders') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                    View all <i class="fas fa-chevron-right ml-1 text-xs"></i>
                </a>
            </div>
            
            @if(isset($orders) && count($orders) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($orders as $order)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">#{{ $order['order_id'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($order['order_date'])->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($order['order_date'])->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $order['status'] ?? 'Completed' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('admin.orders.view', $order['order_id']) }}" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-eye mr-1"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-6 text-center">
                    <div class="inline-flex rounded-full bg-gray-100 p-4 mb-4">
                        <i class="fas fa-shopping-bag text-gray-500 text-xl"></i>
                    </div>
                    <p class="text-gray-500">No orders found</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Recent Users -->    
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="flex justify-between items-center p-6 border-b">
            <h2 class="text-xl font-bold text-gray-800">Recent Users</h2>
            <a href="{{ route('admin.users') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                View all <i class="fas fa-chevron-right ml-1 text-xs"></i>
            </a>        
        </div>
        
        @if(isset($dashboardUsers) && count($dashboardUsers) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($dashboardUsers as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user['user_id'] ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 mr-3">
                                            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                                <span class="text-indigo-800 font-medium">{{ strtoupper(substr($user['user_name'] ?? 'U', 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div class="text-sm text-gray-900">{{ $user['user_name'] ?? 'N/A' }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user['user_email'] ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user['full_name'] ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <form action="{{ route('admin.users.delete', $user['user_id']) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-6 text-center">
                <div class="inline-flex rounded-full bg-gray-100 p-4 mb-4">
                    <i class="fas fa-users text-gray-500 text-xl"></i>
                </div>
                <p class="text-gray-500">No users found</p>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
    // Any needed JavaScript can go here
</script>
@endsection 