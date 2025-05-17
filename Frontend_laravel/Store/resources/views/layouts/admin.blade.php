<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title', 'Dashboard')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .sidebar {
            min-height: calc(100vh - 4rem);
            transition: all 0.3s ease;
        }
        
        .content-area {
            transition: margin-left 0.3s ease;
        }
        
        @media (max-width: 1023px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                z-index: 50;
                top: 4rem;
                bottom: 0;
                width: 16rem;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .sidebar-backdrop {
                display: none;
                position: fixed;
                top: 4rem;
                right: 0;
                bottom: 0;
                left: 0;
                z-index: 40;
                background: rgba(0, 0, 0, 0.5);
            }
            
            .sidebar-backdrop.active {
                display: block;
            }
        }
        
        /* Modern scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c5c5c5;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        /* Notification animation */
        @keyframes slideIn {
            0% { transform: translateX(100%); }
            10% { transform: translateX(0); }
            90% { transform: translateX(0); }
            100% { transform: translateX(100%); }
        }
        
        .notification {
            animation: slideIn 5s forwards;
        }
    </style>
    
    @yield('styles')
</head>
<body class="bg-gray-50 text-gray-800">
    <!-- Top Navbar -->
    <nav class="bg-white border-b border-gray-200 fixed z-30 w-full shadow-sm">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar" class="lg:hidden mr-2 text-gray-600 hover:text-gray-900 cursor-pointer p-2 hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100 rounded">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="text-xl font-semibold flex items-center lg:mr-1.5">
                        <span class="hidden md:inline">
                            <span class="text-blue-600">Admin</span><span>Panel</span>
                        </span>
                        <span class="md:hidden text-blue-600">AP</span>
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <a href="{{ route('home') }}" target="_blank" class="text-gray-500 hover:text-gray-900 p-2 rounded-full hover:bg-gray-100 flex items-center mr-2" title="View Store">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="p-1 bg-gray-100 rounded-full h-9 w-9 flex items-center justify-center hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <i class="fas fa-user"></i>
                            </button>
                            
                            <div x-show="open" 
                                 @click.away="open = false"
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95">
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="sm:hidden">
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-full">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar backdrop (mobile) -->
    <div id="sidebarBackdrop" class="sidebar-backdrop"></div>

    <div class="flex pt-16">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-gradient-to-b from-gray-800 to-gray-900 text-white sidebar w-64">
            <div class="px-4 py-6">
                <div class="flex items-center space-x-2 mb-8">
                    <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center">
                        <i class="fas fa-store text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-bold">E-commerce Store</h3>
                        <p class="text-xs text-gray-400">Admin Dashboard</p>
                    </div>
                </div>
                
                <nav>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" 
                               class="flex items-center px-4 py-3 text-gray-300 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-gray-700' }}">
                                <i class="fas fa-tachometer-alt w-5 h-5"></i>
                                <span class="ml-3">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.products') }}" 
                               class="flex items-center px-4 py-3 text-gray-300 rounded-lg transition-colors {{ request()->routeIs('admin.products*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-700' }}">
                                <i class="fas fa-box w-5 h-5"></i>
                                <span class="ml-3">Products</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.categories') }}" 
                               class="flex items-center px-4 py-3 text-gray-300 rounded-lg transition-colors {{ request()->routeIs('admin.categories*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-700' }}">
                                <i class="fas fa-tags w-5 h-5"></i>
                                <span class="ml-3">Categories</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.orders') }}" 
                               class="flex items-center px-4 py-3 text-gray-300 rounded-lg transition-colors {{ request()->routeIs('admin.orders*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-700' }}">
                                <i class="fas fa-shopping-bag w-5 h-5"></i>
                                <span class="ml-3">Orders</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users') }}" 
                               class="flex items-center px-4 py-3 text-gray-300 rounded-lg transition-colors {{ request()->routeIs('admin.users*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-700' }}">
                                <i class="fas fa-users w-5 h-5"></i>
                                <span class="ml-3">Users</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.contacts') }}" 
                               class="flex items-center px-4 py-3 text-gray-300 rounded-lg transition-colors {{ request()->routeIs('admin.contacts*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-700' }}">
                                <i class="fas fa-envelope w-5 h-5"></i>
                                <span class="ml-3">Contact Messages</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        
        <!-- Main Content -->
        <div id="contentArea" class="content-area flex-1 p-4 md:p-6 lg:p-8">
            <div class="mb-6">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">@yield('title', 'Dashboard')</h1>
                <p class="text-gray-600 mt-1">@yield('subtitle', '')</p>
            </div>
            
            <!-- Notifications -->
            <div id="notifications" class="fixed top-16 right-0 p-4 z-50 space-y-3 w-full max-w-sm">
                @if(session('success'))
                    <div class="notification bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-md" role="alert">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-800">{{ session('success') }}</p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="-mx-1.5 -my-1.5">
                                    <button class="notification-close p-1.5 rounded-md inline-flex text-green-500 hover:bg-green-100 focus:outline-none">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="notification bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-md" role="alert">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-800">{{ session('error') }}</p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="-mx-1.5 -my-1.5">
                                    <button class="notification-close p-1.5 rounded-md inline-flex text-red-500 hover:bg-red-100 focus:outline-none">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                @if(session('warning'))
                    <div class="notification bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded shadow-md" role="alert">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-800">{{ session('warning') }}</p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="-mx-1.5 -my-1.5">
                                    <button class="notification-close p-1.5 rounded-md inline-flex text-yellow-500 hover:bg-yellow-100 focus:outline-none">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            @yield('content')
        </div>
    </div>
    
    <!-- AlpineJS (for dropdowns) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- Custom Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar toggle
            const sidebarToggle = document.getElementById('toggleSidebarMobile');
            const sidebar = document.getElementById('sidebar');
            const sidebarBackdrop = document.getElementById('sidebarBackdrop');
            const contentArea = document.getElementById('contentArea');
            
            if (sidebarToggle && sidebar && sidebarBackdrop) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    sidebarBackdrop.classList.toggle('active');
                });
                
                sidebarBackdrop.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    sidebarBackdrop.classList.remove('active');
                });
            }
            
            // Close notifications
            const notificationCloseButtons = document.querySelectorAll('.notification-close');
            notificationCloseButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const notification = button.closest('.notification');
                    if (notification) {
                        notification.remove();
                    }
                });
            });
            
            // Auto close notifications after 5s
            setTimeout(function() {
                const notifications = document.querySelectorAll('.notification');
                notifications.forEach(notification => {
                    notification.style.display = 'none';
                });
            }, 5000);
        });
    </script>
    
    @yield('scripts')
</body>
</html> 