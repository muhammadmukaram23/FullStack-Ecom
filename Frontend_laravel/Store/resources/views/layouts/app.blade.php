<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Ecommerce Store') }} - @yield('title', 'Home')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fefce8',
                            100: '#fef9c3',
                            200: '#fef08a',
                            300: '#fde047',
                            400: '#facc15',
                            500: '#eab308',
                            600: '#ca8a04',
                            700: '#a16207',
                            800: '#854d0e',
                            900: '#713f12',
                        },
                        secondary: {
                            50: '#fefce8',
                            100: '#fef9c3',
                            200: '#fef08a',
                            300: '#fde047',
                            400: '#facc15',
                            500: '#eab308',
                            600: '#ca8a04',
                            700: '#a16207',
                            800: '#854d0e',
                            900: '#713f12',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .hero-pattern {
            background-color: #f9fafb;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill='%23e5e7eb' fill-opacity='0.4'%3E%3Cpath fill-rule='evenodd' d='M0 0h40v40H0V0zm40 40h40v40H40V40zm0-40h2l-2 2V0zm0 4l4-4h2l-6 6V4zm0 4l8-8h2L40 10V8zm0 4L52 0h2L40 14v-2zm0 4L56 0h2L40 18v-2zm0 4L60 0h2L40 22v-2zm0 4L64 0h2L40 26v-2zm0 4L68 0h2L40 30v-2zm0 4L72 0h2L40 34v-2zm0 4L76 0h2L40 38v-2zm0 4L80 0v2L42 40h-2zm4 0L80 4v2L46 40h-2zm4 0L80 8v2L50 40h-2zm4 0l28-28v2L54 40h-2zm4 0l24-24v2L58 40h-2zm4 0l20-20v2L62 40h-2zm4 0l16-16v2L66 40h-2zm4 0l12-12v2L70 40h-2zm4 0l8-8v2l-6 6h-2zm4 0l4-4v2l-2 2h-2z'/%3E%3C/g%3E%3C/svg%3E");
        }
                .btn-gradient {            background: #ca8a04; /* Solid yellow instead of gradient */        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
    
    @yield('styles')
</head>
<body class="flex flex-col min-h-screen bg-gray-50">
    <!-- Announcement Bar -->
    <!-- <div class="bg-gradient-to-r from-primary-600 to-secondary-600 text-white py-2">
        <div class="container mx-auto px-4 text-center text-sm font-medium">
            Free shipping on all orders over $50! Use code: FREESHIP
        </div>
    </div> -->
    
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <nav class="flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center">
                                        <span class="text-2xl font-bold text-yellow-600">                        EliteShop                    </span>
                </a>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-yellow-600 font-medium {{ request()->routeIs('home') ? 'text-yellow-600 border-b-2 border-yellow-600 pb-1' : '' }}">Home</a>
                    
                    <!-- Categories Dropdown -->
                    <div class="relative group">
                        <button class="text-gray-700 hover:text-yellow-600 font-medium flex items-center {{ request()->routeIs('products.category') ? 'text-yellow-600 border-b-2 border-yellow-600 pb-1' : '' }}">
                            Categories <i class="fas fa-chevron-down text-xs ml-1"></i>
                        </button>
                        <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 transform opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transition-all duration-200 origin-top-left">
                            @if(isset($navCategories) && count($navCategories) > 0)
                                @foreach($navCategories as $category)
                                    <a href="{{ route('products.category', $category['category_id']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-yellow-600">
                                        {{ $category['category_name'] }}
                                    </a>
                                @endforeach
                            @else
                                <div class="block px-4 py-2 text-sm text-gray-500">No categories found</div>
                            @endif
                        </div>
                    </div>
                    
                    <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-yellow-600 font-medium {{ request()->routeIs('products.*') && !request()->routeIs('products.category') ? 'text-yellow-600 border-b-2 border-yellow-600 pb-1' : '' }}">Shop</a>                    <a href="{{ route('about') }}" class="text-gray-700 hover:text-yellow-600 font-medium {{ request()->routeIs('about') ? 'text-yellow-600 border-b-2 border-yellow-600 pb-1' : '' }}">About</a>                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-yellow-600 font-medium {{ request()->routeIs('contact') ? 'text-yellow-600 border-b-2 border-yellow-600 pb-1' : '' }}">Contact</a>
                </div>
                
                <!-- Right Navigation: Cart & Auth -->
                <div class="flex items-center space-x-6 relative">
                    <!-- Search - Hidden on mobile since it's in the burger menu -->
                    <div class="relative group hidden sm:block">
                        <button id="search-toggle" class="text-gray-700 hover:text-yellow-600 focus:outline-none p-2 rounded-full hover:bg-gray-100 transition-colors">
                            <i class="fas fa-search text-xl"></i>
                        </button>
                        
                        <!-- Search Dropdown -->
                        <div id="search-dropdown" class="hidden absolute right-0 left-0 sm:left-auto mt-2 w-full sm:w-72 md:w-96 bg-white rounded-lg shadow-lg z-50 overflow-hidden transition-all duration-200 transform origin-top-right">
                            <form action="{{ route('products.search') }}" method="GET" class="flex items-center w-full">
                                <input 
                                    type="text" 
                                    name="query" 
                                    placeholder="Search products..." 
                                    class="w-full px-4 py-3 border-0 focus:outline-none focus:ring-0"
                                    required
                                >
                                                                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-5 py-3 transition">                                    <i class="fas fa-search"></i>                                </button>
                            </form>
                        </div>
                    </div>
                    
                    @if(Session::has('is_logged_in') && Session::get('is_logged_in'))
                    <!-- Wishlist -->
                    <a href="{{ route('wishlist.index') }}" class="text-gray-700 hover:text-yellow-600 relative p-2 rounded-full hover:bg-gray-100 transition-colors">
                        <i class="far fa-heart text-xl"></i>
                    </a>
                    @endif
                    
                    <!-- Cart -->
                                        <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-yellow-600 relative p-2 rounded-full hover:bg-gray-100 transition-colors">                        <i class="fas fa-shopping-cart text-xl"></i>                        <span class="absolute -top-1 -right-1 bg-yellow-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold">                            {{ session('cart_count', 0) }}                        </span>                    </a>
                    
                    <!-- Authentication -->
                    @if(Session::has('is_logged_in') && Session::get('is_logged_in'))
                        <div class="relative group">
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-yellow-600 focus:outline-none">
                                <span>{{ Session::get('user.user_name', 'User') }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden group-hover:block border border-gray-100">
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-yellow-600">My Orders</a>
                                <a href="{{ route('wishlist.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-yellow-600">My Wishlist</a>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-yellow-600">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-yellow-600 font-medium">Login</a>                        <a href="{{ route('register') }}" class="bg-yellow-600 text-white px-5 py-2 rounded-full font-medium hover:shadow-md transition hover:bg-yellow-700">Register</a>
                    @endif
                    
                    <!-- Mobile Menu Button -->
                    <div class="md:hidden">
                        <button id="mobile-menu-button" class="text-gray-700 focus:outline-none">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
            </nav>
            
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="md:hidden hidden mt-4 pb-4">
                <!-- Mobile Search -->
                <div class="mb-4">
                    <form action="{{ route('products.search') }}" method="GET" class="flex w-full items-center overflow-hidden rounded-lg border border-gray-300">
                        <input 
                            type="text" 
                            name="query" 
                            placeholder="Search products..." 
                            class="w-full px-4 py-3 border-0 focus:outline-none focus:ring-0"
                        >
                        <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-3 transition">                            <i class="fas fa-search"></i>                        </button>
                    </form>
                </div>
                
                <a href="{{ route('home') }}" class="block py-2 text-gray-700 hover:text-yellow-600 font-medium {{ request()->routeIs('home') ? 'text-yellow-600 bg-yellow-50 pl-2 rounded-lg' : '' }}">Home</a>
                
                <!-- Categories in Mobile Menu -->
                <div class="py-2">
                    <button id="mobile-categories-toggle" class="flex justify-between items-center w-full text-gray-700 hover:text-yellow-600 font-medium {{ request()->routeIs('products.category') ? 'text-yellow-600 bg-yellow-50 pl-2 rounded-lg' : '' }}">
                        Categories <i class="fas fa-chevron-down text-xs ml-1"></i>
                    </button>
                    <div id="mobile-categories-menu" class="hidden mt-2 ml-4 space-y-2">
                        @if(isset($navCategories) && count($navCategories) > 0)
                            @foreach($navCategories as $category)
                                <a href="{{ route('products.category', $category['category_id']) }}" class="block py-2 text-gray-700 hover:text-yellow-600">
                                    {{ $category['category_name'] }}
                                </a>
                            @endforeach
                        @else
                            <div class="py-2 text-gray-500">No categories found</div>
                        @endif
                    </div>
                </div>
                
                <a href="{{ route('products.index') }}" class="block py-2 text-gray-700 hover:text-yellow-600 font-medium {{ request()->routeIs('products.*') && !request()->routeIs('products.category') ? 'text-yellow-600 bg-yellow-50 pl-2 rounded-lg' : '' }}">Shop</a>
                <a href="{{ route('about') }}" class="block py-2 text-gray-700 hover:text-yellow-600 font-medium {{ request()->routeIs('about') ? 'text-yellow-600 bg-yellow-50 pl-2 rounded-lg' : '' }}">About</a>
                <a href="{{ route('contact') }}" class="block py-2 text-gray-700 hover:text-yellow-600 font-medium {{ request()->routeIs('contact') ? 'text-yellow-600 bg-yellow-50 pl-2 rounded-lg' : '' }}">Contact</a>
                
                @if(Session::has('is_logged_in') && Session::get('is_logged_in'))
                    <a href="{{ route('wishlist.index') }}" class="block py-2 text-gray-700 hover:text-yellow-600 font-medium {{ request()->routeIs('wishlist.*') ? 'text-yellow-600 bg-yellow-50 pl-2 rounded-lg' : '' }}">My Wishlist</a>
                    <a href="{{ route('orders.index') }}" class="block py-2 text-gray-700 hover:text-primary-600 font-medium">My Orders</a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left py-2 text-gray-700 hover:text-yellow-600 font-medium">
                            Logout
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </header>
    
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-4 container mx-auto mt-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-4 container mx-auto mt-4" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif
    
    <!-- Content -->
    <main class="flex-grow">
        @yield('content')
    </main>
    
    <!-- Newsletter -->
    <section class=" bg-white text-black py-12 border border-gray-200 shadow-md rounded-lg" >
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto text-center">
                <h3 class="text-2xl font-bold mb-2">Join Our Newsletter</h3>
                <p class="text-gray-300 mb-4">Stay updated with the latest products, exclusive offers, and news</p>
                <form class="flex flex-col sm:flex-row gap-2 justify-center">
                    <input type="email" placeholder="Your email address" class="px-4 py-3 rounded-full focus:outline-none focus:ring-2 focus:ring-primary-500 flex-grow max-w-md">
                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-full font-medium hover:shadow-lg">Subscribe</button>
                </form>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class=" text-black pt-16 pb-6" style="color:#e8eaed">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4 text-yellow-600">EliteShop</h3>
                    <p class="text-gray-400">Your premium destination for high-quality products with exceptional service.</p>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4 text-black">Shop</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-white transition">All Products</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">New Arrivals</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Best Sellers</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Special Offers</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4 text-black">Customer Service</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Help Center</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Shipping Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Returns & Refunds</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Order Tracking</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4 text-black">Contact</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-2 text-yellow-500"></i>
                            <span class="text-gray-400">123 Main St, City, Country</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone mt-1 mr-2 text-yellow-500"></i>
                            <span class="text-gray-400">+1 234 567 8900</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-2 text-yellow-500"></i>
                            <span class="text-gray-400">support@eliteshop.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-10 pt-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} EliteShop. All rights reserved.</p>
                <div class="mt-4 md:mt-0 flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition">Terms of Service</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition">Legal</a>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- JavaScript -->
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
        const searchToggle = document.getElementById('search-toggle');
        const searchDropdown = document.getElementById('search-dropdown');
            const mobileCategoriesToggle = document.getElementById('mobile-categories-toggle');
            const mobileCategoriesMenu = document.getElementById('mobile-categories-menu');

            // Toggle mobile menu
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                    mobileMenuButton.innerHTML = mobileMenu.classList.contains('hidden') 
                        ? '<i class="fas fa-bars text-xl"></i>' 
                        : '<i class="fas fa-times text-xl"></i>';
                });
            }

            // Toggle search dropdown
        if (searchToggle && searchDropdown) {
                searchToggle.addEventListener('click', function() {
                searchDropdown.classList.toggle('hidden');
                });
                
                // Close search dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!searchToggle.contains(e.target) && !searchDropdown.contains(e.target)) {
                        searchDropdown.classList.add('hidden');
                    }
                });
            }
            
            // Toggle mobile categories menu
            if (mobileCategoriesToggle && mobileCategoriesMenu) {
                mobileCategoriesToggle.addEventListener('click', function() {
                    mobileCategoriesMenu.classList.toggle('hidden');
                    const icon = mobileCategoriesToggle.querySelector('i');
                    if (icon) {
                        if (mobileCategoriesMenu.classList.contains('hidden')) {
                            icon.className = 'fas fa-chevron-down text-xs ml-1';
                        } else {
                            icon.className = 'fas fa-chevron-up text-xs ml-1';
                        }
                }
            });
        }

        // Handle the wishlist heart buttons with AJAX
        const wishlistButtons = document.querySelectorAll('.wishlist-button');
        
        wishlistButtons.forEach(button => {
            const productId = button.dataset.productId;
            
            // Check if product is in wishlist
            fetch(`/wishlist/check/${productId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.in_wishlist) {
                        button.classList.add('text-red-500');
                        button.innerHTML = '<i class="fas fa-heart mr-2"></i> In Wishlist';
                    } else {
                        button.classList.add('text-gray-400');
                        button.innerHTML = '<i class="far fa-heart mr-2"></i> Add to Wishlist';
                    }
                });
            
            // Toggle wishlist status with click
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                fetch('/wishlist/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ product_id: productId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (button.classList.contains('text-red-500')) {
                            button.classList.remove('text-red-500');
                            button.classList.add('text-gray-400');
                            button.innerHTML = '<i class="far fa-heart mr-2"></i> Add to Wishlist';
                        } else {
                            button.classList.remove('text-gray-400');
                            button.classList.add('text-red-500');
                            button.innerHTML = '<i class="fas fa-heart mr-2"></i> In Wishlist';
                        }
                    }
                });
            });
        });
        });
    </script>
    
    @yield('scripts')
</body>
</html> 