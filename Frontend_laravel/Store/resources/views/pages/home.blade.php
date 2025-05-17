@extends('layouts.app')

@section('title', 'Home')

@section('content')
        <!-- Hero Section -->    <section class="relative overflow-hidden bg-yellow-600 text-white">        <!-- Animated Background Pattern -->        <div class="absolute inset-0 opacity-10">            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>        </div>
        
        <div class="container mx-auto px-4 py-20 md:py-28 relative z-10">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="w-full md:w-1/2 mb-10 md:mb-0 md:pr-8">
                    <div class="max-w-xl">
                        <span class="inline-block px-3 py-1 bg-white bg-opacity-20 backdrop-blur-sm text-white text-sm font-medium rounded-full mb-5">Premium Shopping Experience</span>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight animate-fade-up">
                            Discover <span class="text-white relative inline-block">
                                Premium
                                <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 138 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 14C25.6397 14 45.2794 14 134 14" stroke="#FEF08A" stroke-width="8" stroke-linecap="round"/>
                                </svg>
                            </span> Products for Your Lifestyle
                        </h1>
                        <p class="text-lg md:text-xl mb-8 text-gray-100 max-w-xl">
                            Shop the latest trends with confidence. Quality products, fast shipping, and exceptional service for the modern shopper.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('products.index') }}" class="bg-white text-yellow-600 px-8 py-3 rounded-full font-bold hover:bg-gray-100 transition shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                Shop Now
                            </a>
                            <a href="{{ route('about') }}" class="border-2 border-white text-white px-8 py-3 rounded-full font-bold hover:bg-white hover:text-yellow-600 transition transform hover:-translate-y-1">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/2 flex justify-center">
                    <div class="relative">
                        <div class="absolute -top-4 -left-4 w-20 h-20 bg-yellow-300 rounded-full opacity-50 animate-pulse"></div>
                        <div class="absolute -bottom-8 -right-8 w-40 h-40 bg-yellow-300 rounded-full opacity-30 animate-pulse delay-300"></div>
                        <img src="https://images.unsplash.com/photo-1607082349566-187342175e2f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80" 
                            alt="Hero Image" 
                            class="w-full max-w-lg rounded-2xl shadow-2xl object-cover relative z-10 border-4 border-white transform transition duration-700 hover:scale-105">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-14 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="flex items-start p-6 bg-gray-50 rounded-xl border border-gray-100 shadow-sm transform transition hover:shadow-md hover:-translate-y-1">
                                        <div class="bg-yellow-100 p-4 rounded-xl mr-4">                        <i class="fas fa-truck text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-2">Free & Fast Shipping</h3>
                        <p class="text-gray-600">Free shipping on all orders over $50</p>
                    </div>
                </div>
                <div class="flex items-start p-6 bg-gray-50 rounded-xl border border-gray-100 shadow-sm transform transition hover:shadow-md hover:-translate-y-1">
                                        <div class="bg-yellow-100 p-4 rounded-xl mr-4">                        <i class="fas fa-shield-alt text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-2">Secure Payments</h3>
                        <p class="text-gray-600">100% secure payment processing</p>
                    </div>
                </div>
                <div class="flex items-start p-6 bg-gray-50 rounded-xl border border-gray-100 shadow-sm transform transition hover:shadow-md hover:-translate-y-1">
                                        <div class="bg-yellow-100 p-4 rounded-xl mr-4">                        <i class="fas fa-undo text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-2">Easy Returns</h3>
                        <p class="text-gray-600">30-day money-back guarantee</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

        <!-- Categories Section -->    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-medium rounded-full mb-3">COLLECTIONS</span>
                <h2 class="text-3xl font-bold mb-4">Shop by Category</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Browse our wide selection of products across various categories to find exactly what you're looking for.</p>
            </div>
            
            <!-- Categories Carousel -->
            <div class="relative categories-carousel max-w-6xl mx-auto">
                <!-- Left Arrow -->
                <button class="absolute -left-4 top-1/2 transform -translate-y-1/2 bg-white rounded-full shadow-md p-2 z-10 focus:outline-none carousel-prev">
                    <i class="fas fa-chevron-left text-yellow-600 text-xl"></i>
                </button>
                
                <!-- Carousel Container -->
                <div class="carousel-container overflow-x-auto hide-scrollbar py-6 px-2">
                    <div class="carousel-track flex items-center space-x-6 transition-transform duration-300">
                        @if(isset($categories) && count($categories) > 0)
                            @foreach($categories as $category)
                                <div class="carousel-item flex-shrink-0">
                                    <a href="{{ route('products.category', $category['category_id']) }}" class="category-circle-item block text-center group">
                                                                                <div class="w-20 h-20 md:w-24 md:h-24 rounded-full bg-gradient-to-br from-yellow-50 to-white shadow-sm border border-gray-100 flex items-center justify-center mx-auto mb-3 group-hover:shadow-md group-hover:scale-105 transition-all duration-300">                                            <i class="fas fa-tags text-yellow-500 text-2xl group-hover:text-yellow-600"></i>
                                        </div>
                                        <h3 class="text-sm font-medium text-gray-700 group-hover:text-yellow-600 transition-colors line-clamp-1">{{ $category['category_name'] }}</h3>
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="w-full text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-tag text-2xl text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-700">No Categories Available</h3>
                                <p class="text-gray-500 text-sm mt-2">Check back later for updated categories.</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Right Arrow -->
                <button class="absolute -right-4 top-1/2 transform -translate-y-1/2 bg-white rounded-full shadow-md p-2 z-10 focus:outline-none carousel-next">
                    <i class="fas fa-chevron-right text-yellow-600 text-xl"></i>
                </button>
                
                <!-- Carousel Indicators -->
                <div class="flex justify-center mt-6 carousel-indicators">
                    <!-- Indicators will be added via JavaScript -->
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center mb-12">
                <div>
                    <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-medium rounded-full mb-3">FEATURED</span>
                    <h2 class="text-3xl font-bold mb-4">Featured Products</h2>
                    <p class="text-gray-600 max-w-2xl">Discover our most popular products handpicked for you.</p>
                </div>
                <a href="{{ route('products.index') }}" class="mt-4 md:mt-0 group text-yellow-600 font-medium hover:text-yellow-700 flex items-center transition-all duration-300">
                    View All Products
                    <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @if(isset($products) && count($products) > 0)
                    @foreach($products as $product)
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 product-card">
                            <a href="{{ route('products.show', $product['product_id']) }}" class="block">
                                <div class="product-image-container">
                                    @if(isset($product['images']) && count($product['images']) > 0)
                                        <img src="{{ $product['images'][0]['image_url'] }}" alt="{{ $product['product_name'] }}" class="product-image">
                                    @else
                                        <img src="https://via.placeholder.com/300x300" alt="{{ $product['product_name'] }}" class="product-image">
                                    @endif
                                    <div class="absolute top-0 right-0 mt-3 mr-3 transform transition hover:scale-110">
                                        <button class="bg-white text-gray-700 hover:text-yellow-600 p-2 rounded-full shadow-md transition">
                                            <i class="far fa-heart"></i>
                                        </button>
                                    </div>
                                </div>
                            </a>
                            <div class="product-info">
                                <a href="{{ route('products.show', $product['product_id']) }}" class="block">
                                    <h3 class="product-title">{{ $product['product_name'] }}</h3>
                                </a>
                                <p class="product-description line-clamp-2">
                                    {{ \Illuminate\Support\Str::limit($product['product_description'], 80) }}
                                </p>
                                <div class="product-price-cart">
                                    <span class="product-price">${{ number_format($product['product_price'], 2) }}</span>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product['product_id'] }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="add-to-cart">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-4 bg-white rounded-xl p-12 text-center shadow-sm border border-gray-100">
                        <div class="flex justify-center mb-4">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-box-open text-3xl text-gray-400"></i>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2">No Products Available</h3>
                        <p class="text-gray-600 mb-6">Check back later for our latest products.</p>
                                                <a href="{{ route('products.index') }}" class="bg-yellow-600 text-white px-6 py-3 rounded-lg hover:bg-yellow-700 inline-block transition shadow-md">                            Browse All Products                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>

        <!-- Testimonials Section -->    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-medium rounded-full mb-3">TESTIMONIALS</span>
                <h2 class="text-3xl font-bold mb-4">What Our Customers Say</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Don't just take our word for it. Here's what our satisfied customers have to say about their shopping experience.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative">
                    <div class="absolute -top-4 -right-4 w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-quote-right text-yellow-600"></i>
                    </div>
                    <div class="flex text-yellow-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-600 mb-6">"I'm extremely satisfied with my purchase. The quality of the product exceeded my expectations, and the delivery was super fast!"</p>
                    <div class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/women/62.jpg" alt="Customer" class="w-12 h-12 rounded-full mr-4 border-2 border-yellow-100">
                        <div>
                            <h4 class="font-semibold">Sarah Johnson</h4>
                            <p class="text-gray-500 text-sm">Loyal Customer</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative">
                    <div class="absolute -top-4 -right-4 w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-quote-right text-yellow-600"></i>
                    </div>
                    <div class="flex text-yellow-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-600 mb-6">"The customer service is exceptional! Had a small issue with my order and they resolved it immediately. Will definitely shop here again."</p>
                    <div class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Customer" class="w-12 h-12 rounded-full mr-4 border-2 border-yellow-100">
                        <div>
                            <h4 class="font-semibold">Michael Roberts</h4>
                            <p class="text-gray-500 text-sm">Happy Customer</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 relative">
                    <div class="absolute -top-4 -right-4 w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-quote-right text-yellow-600"></i>
                    </div>
                    <div class="flex text-yellow-400 mb-4">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="text-gray-600 mb-6">"Great selection of products at competitive prices. The website is easy to navigate, and checkout was a breeze. Highly recommended!"</p>
                    <div class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Customer" class="w-12 h-12 rounded-full mr-4 border-2 border-yellow-100">
                        <div>
                            <h4 class="font-semibold">Emma Thompson</h4>
                            <p class="text-gray-500 text-sm">New Customer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

        <!-- Call to Action -->    <section class="py-20 relative overflow-hidden">        <div class="absolute inset-0 bg-yellow-600"></div>        <!-- Background Pattern -->        <div class="absolute inset-0 opacity-10">            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'80\' height=\'80\' viewBox=\'0 0 80 80\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M0 0h40v40H0V0zm40 40h40v40H40V40zm0-40h2l-2 2V0zm0 4l4-4h2l-6 6V4zm0 4l8-8h2L40 10V8zm0 4L52 0h2L40 14v-2zm0 4L56 0h2L40 18v-2zm0 4L60 0h2L40 22v-2zm0 4L64 0h2L40 26v-2zm0 4L68 0h2L40 30v-2zm0 4L72 0h2L40 34v-2zm0 4L76 0h2L40 38v-2zm0 4L80 0v2L42 40h-2zm4 0L80 4v2L46 40h-2zm4 0L80 8v2L50 40h-2zm4 0l28-28v2L54 40h-2zm4 0l24-24v2L58 40h-2zm4 0l20-20v2L62 40h-2zm4 0l16-16v2L66 40h-2zm4 0l12-12v2L70 40h-2zm4 0l8-8v2l-6 6h-2zm4 0l4-4v2l-2 2h-2z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>        </div>
        
        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold mb-6 text-white">Ready to Start Shopping?</h2>
                <p class="text-xl mb-8 text-white text-opacity-90 max-w-2xl mx-auto">Join thousands of satisfied customers and experience our premium products and exceptional service today.</p>
                <a href="{{ route('products.index') }}" class="bg-white text-yellow-600 px-8 py-4 rounded-full font-bold hover:bg-gray-100 inline-block transition shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    Shop Now
                </a>
            </div>
        </div>
    </section>
    
    <!-- Brands Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10">
                <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-medium rounded-full mb-3">PARTNERS</span>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Trusted By Top Brands</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">We partner with leading brands to bring you the highest quality products.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-6 md:gap-8 max-w-4xl mx-auto">
                <div class="flex items-center justify-center p-4 h-24">
                    <img src="{{ asset('images/logo.png') }}" alt="Brand Logo" class="max-h-12 transition-opacity duration-300">
                </div>
                <div class="flex items-center justify-center p-4 h-24">
                    <img src="{{ asset('images/logo.png') }}" alt="Brand Logo" class="max-h-12 transition-opacity duration-300">
                </div>
                <div class="flex items-center justify-center p-4 h-24">
                    <img src="{{ asset('images/logo.png') }}" alt="Brand Logo" class="max-h-12 transition-opacity duration-300">
                </div>
                <div class="flex items-center justify-center p-4 h-24">
                    <img src="{{ asset('images/logo.png') }}" alt="Brand Logo" class="max-h-12 transition-opacity duration-300">
                </div>
                <div class="flex items-center justify-center p-4 h-24">
                    <img src="{{ asset('images/logo.png') }}" alt="Brand Logo" class="max-h-12 transition-opacity duration-300">
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
<style>
    @keyframes fade-up {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-up {
        animation: fade-up 0.6s ease-out forwards;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 0.5;
            transform: scale(1);
        }
        50% {
            opacity: 0.8;
            transform: scale(1.05);
        }
    }
    
    .animate-pulse {
        animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    .delay-300 {
        animation-delay: 300ms;
    }
    
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }
    
    /* Product Card Styles */
    .product-card {
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    .product-image-container {
        position: relative;
        height: 220px;
        background: #f9fafb;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .product-image {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
        padding: 10px;
        transition: transform 0.5s ease;
    }
    
    .product-image:hover {
        transform: scale(1.05);
    }
    
    .product-info {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    
    .product-title {
        font-weight: 600;
        font-size: 1.125rem;
        margin-bottom: 0.5rem;
        color: #1f2937;
        transition: color 0.3s ease;
    }
    
        .product-title:hover {        color: #ca8a04;    }
    
    .product-description {
        color: #6b7280;
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }
    
    .product-price-cart {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }
    
    .product-price {
        font-weight: 700;
        font-size: 1.25rem;
        color: #1f2937;
    }
    
        .add-to-cart {        background-color: #ca8a04;        color: white;        border-radius: 9999px;        padding: 0.5rem;        transition: all 0.3s ease;    }        .add-to-cart:hover {        background-color: #a16207;        transform: scale(1.1);    }
    
    /* Categories Carousel Styles */
    .categories-carousel {
        position: relative;
        --items-per-slide: 7;
        padding: 0 1rem;
    }
    
    .carousel-container {
        overflow-x: auto;
        position: relative;
        width: 100%;
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none; /* IE and Edge */
        scroll-behavior: smooth;
        padding: 1rem 0;
    }
    
    .carousel-container::-webkit-scrollbar {
        display: none; /* Chrome, Safari and Opera */
    }
    
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    
    .carousel-track {
        display: flex;
        align-items: center;
        transition: transform 0.3s ease;
        padding: 0.5rem 0;
    }
    
    .carousel-item {
        flex: 0 0 auto;
        width: calc(100% / var(--items-per-slide));
        min-width: 100px;
        transition: all 0.3s ease;
    }
    
    .category-circle-item {
        transition: all 0.3s ease;
    }
    
    .category-circle-item:hover {
        transform: translateY(-5px);
    }
    
    .carousel-prev,
    .carousel-next {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 20;
        border: none;
    }
    
    .carousel-prev:hover,
    .carousel-next:hover {
        background: #f9fafb;
        transform: scale(1.05);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1), 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    
        .carousel-prev:focus,    .carousel-next:focus {        outline: none;        box-shadow: 0 0 0 3px rgba(202, 138, 4, 0.3), 0 4px 6px rgba(0, 0, 0, 0.1);    }
    
    .carousel-indicators {
        margin-top: 1rem;
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .carousel-indicators button {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #d1d5db;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        padding: 0;
    }
    
        .carousel-indicators button.active {        background-color: #ca8a04;        width: 10px;        height: 10px;    }
    
    @media (max-width: 768px) {
        .categories-carousel {
            --items-per-slide: 4;
        }
    }
    
    @media (max-width: 640px) {
        .categories-carousel {
            --items-per-slide: 3;
            padding: 0;
        }
        
        .carousel-prev, 
        .carousel-next {
            width: 36px;
            height: 36px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Categories Carousel Functionality
        const carousel = document.querySelector('.categories-carousel');
        if (!carousel) return;
        
        const container = carousel.querySelector('.carousel-container');
        const track = carousel.querySelector('.carousel-track');
        const items = carousel.querySelectorAll('.carousel-item');
        const prevButton = carousel.querySelector('.carousel-prev');
        const nextButton = carousel.querySelector('.carousel-next');
        const indicatorsContainer = carousel.querySelector('.carousel-indicators');
        
        // Skip if no categories
        if (items.length === 0) return;
        
        // Configuration
        const itemsPerPage = 7; // Display 7 items per page
        const itemWidth = 100 / itemsPerPage; // Width percentage per item
        let currentPage = 0;
        const totalPages = Math.ceil(items.length / itemsPerPage);
        let isDragging = false;
        let startPosition = 0;
        let currentTranslate = 0;
        
        // Set up the carousel
        function setupCarousel() {
            // Create indicators
            indicatorsContainer.innerHTML = '';
            for (let i = 0; i < totalPages; i++) {
                const indicator = document.createElement('button');
                indicator.setAttribute('aria-label', `Page ${i + 1}`);
                
                if (i === 0) {
                    indicator.classList.add('active');
                }
                
                indicator.addEventListener('click', () => {
                    goToPage(i);
                });
                
                indicatorsContainer.appendChild(indicator);
            }
            
            // Set up drag to scroll
            container.addEventListener('mousedown', dragStart);
            container.addEventListener('touchstart', dragStart);
            container.addEventListener('mousemove', drag);
            container.addEventListener('touchmove', drag);
            container.addEventListener('mouseup', dragEnd);
            container.addEventListener('mouseleave', dragEnd);
            container.addEventListener('touchend', dragEnd);
            
            // Update on scroll
            container.addEventListener('scroll', updateOnScroll);
            
            // Navigation buttons
            prevButton.addEventListener('click', () => {
                if (currentPage > 0) {
                    goToPage(currentPage - 1);
                }
            });
            
            nextButton.addEventListener('click', () => {
                if (currentPage < totalPages - 1) {
                    goToPage(currentPage + 1);
                }
            });
            
            // Apply initial responsive styles
            updateResponsiveDisplay();
            window.addEventListener('resize', updateResponsiveDisplay);
        }
        
        function updateResponsiveDisplay() {
            // Update items per page based on screen width
            let newItemsPerPage = 7;
            
            if (window.innerWidth < 768) {
                newItemsPerPage = 4;
            }
            
            if (window.innerWidth < 640) {
                newItemsPerPage = 3;
            }
            
            if (newItemsPerPage !== itemsPerPage) {
                // Update items per page and recalculate
                carousel.style.setProperty('--items-per-slide', newItemsPerPage);
                updateNavigation();
            }
        }
        
        function dragStart(e) {
            isDragging = true;
            startPosition = getPositionX(e);
            container.style.cursor = 'grabbing';
        }
        
        function drag(e) {
            if (!isDragging) return;
            e.preventDefault();
            const currentPosition = getPositionX(e);
            const diff = currentPosition - startPosition;
            container.scrollLeft -= diff;
            startPosition = currentPosition;
        }
        
        function dragEnd() {
            isDragging = false;
            container.style.cursor = 'grab';
            
            // Calculate current page based on scroll position
            const scrollPercentage = container.scrollLeft / (container.scrollWidth - container.clientWidth);
            const targetPage = Math.round(scrollPercentage * (totalPages - 1));
            if (targetPage !== currentPage) {
                updateActivePage(targetPage);
            }
        }
        
        function getPositionX(e) {
            return e.type.includes('mouse') ? e.pageX : e.touches[0].clientX;
        }
        
        function updateOnScroll() {
            if (isDragging) return;
            
            // Calculate current page based on scroll position
            const scrollPercentage = container.scrollLeft / (container.scrollWidth - container.clientWidth);
            const pagePercentage = scrollPercentage * (totalPages - 1);
            const targetPage = Math.round(pagePercentage);
            
            if (targetPage !== currentPage) {
                updateActivePage(targetPage);
                updateNavigation();
            }
        }
        
        function goToPage(page) {
            currentPage = page;
            const scrollAmount = (container.scrollWidth - container.clientWidth) * (page / (totalPages - 1));
            
            container.scrollTo({
                left: scrollAmount,
                behavior: 'smooth'
            });
            
            updateActivePage(page);
            updateNavigation();
        }
        
        function updateActivePage(page) {
            currentPage = page;
            
            // Update indicators
            const indicators = indicatorsContainer.querySelectorAll('button');
            indicators.forEach((indicator, index) => {
                if (index === page) {
                    indicator.classList.add('active');
                } else {
                    indicator.classList.remove('active');
                }
            });
        }
        
        function updateNavigation() {
            // Update button states
            prevButton.disabled = currentPage === 0;
            nextButton.disabled = currentPage === totalPages - 1;
            
            prevButton.style.opacity = currentPage === 0 ? '0.5' : '1';
            nextButton.style.opacity = currentPage === totalPages - 1 ? '0.5' : '1';
        }
        
        // Initialize
        setupCarousel();
        
        // Auto-scroll functionality
        let autoScrollInterval;
        
        function startAutoScroll() {
            autoScrollInterval = setInterval(() => {
                if (currentPage < totalPages - 1) {
                    goToPage(currentPage + 1);
                } else {
                    goToPage(0);
                }
            }, 5000);
        }
        
        function stopAutoScroll() {
            clearInterval(autoScrollInterval);
        }
        
        // Start auto-scroll
        startAutoScroll();
        
        // Pause on hover/touch
        carousel.addEventListener('mouseenter', stopAutoScroll);
        carousel.addEventListener('mouseleave', startAutoScroll);
        carousel.addEventListener('touchstart', stopAutoScroll);
        carousel.addEventListener('touchend', startAutoScroll);
    });
</script>
@endsection 