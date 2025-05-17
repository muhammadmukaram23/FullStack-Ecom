@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <!-- Hero Section -->
    <div class="bg-yellow-600 text-white rounded-lg shadow-lg overflow-hidden mb-12" style="color: white; padding: 10px; text-align: center;">
        <div class="container mx-auto px-4 py-16">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">About Us</h1>
                <p class="text-xl">Learn more about our company and our mission to provide the best products at affordable prices.</p>
            </div>
        </div>
    </div>
    
    <!-- Our Story Section -->
    <div class="mb-12">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div>
                        <h2 class="text-3xl font-bold mb-4">Our Story</h2>
                        <p class="text-gray-700 mb-4">
                            Founded in 2023, E-Store began with a simple mission: to make quality products accessible to everyone. 
                            What started as a small online shop has grown into a comprehensive e-commerce platform offering 
                            thousands of products across multiple categories.
                        </p>
                        <p class="text-gray-700 mb-4">
                            Our founder, Jane Doe, recognized a gap in the market for an online store that combined quality, 
                            affordability, and exceptional customer service. Drawing from her background in retail and technology, 
                            she built E-Store from the ground up with a customer-first approach.
                        </p>
                        <p class="text-gray-700">
                            Today, we serve customers nationwide and are continuously expanding our product range to meet the 
                            evolving needs of our loyal customer base.
                        </p>
                    </div>
                    <div class="rounded-lg overflow-hidden shadow-md">
                        <img src="{{ asset('images/johny.webp') }}" alt="Our Story" class="w-full h-auto">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Our Values Section -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold mb-6">Our Values</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                                <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">                    <i class="fas fa-star text-2xl text-yellow-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Quality</h3>
                <p class="text-gray-700">
                    We carefully curate our product selection to ensure we offer only the best quality items. Each product undergoes 
                    rigorous quality checks before being listed on our platform.
                </p>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md">
                                <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">                    <i class="fas fa-users text-2xl text-yellow-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Customer Focus</h3>
                <p class="text-gray-700">
                    Our customers are at the heart of everything we do. We strive to provide exceptional service, from browsing 
                    our store to receiving your order and beyond.
                </p>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md">
                                <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">                    <i class="fas fa-leaf text-2xl text-yellow-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Sustainability</h3>
                <p class="text-gray-700">
                    We're committed to reducing our environmental impact. From eco-friendly packaging to partnering with sustainable 
                    brands, we're working towards a greener future.
                </p>
            </div>
        </div>
    </div>
    
    <!-- Our Team Section -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold mb-6">Our Team</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ asset('images/johny.webp') }}" alt="Jane Doe" class="w-full h-64 object-cover">
                <div class="p-4 text-center">
                    <h3 class="text-xl font-bold mb-1">Jane Doe</h3>
                    <p class="text-gray-600 mb-3">Founder & CEO</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-gray-400 hover:text-yellow-600"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-gray-400 hover:text-yellow-600"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ asset('images/johny.webp') }}" alt="John Smith" class="w-full h-64 object-cover">
                <div class="p-4 text-center">
                    <h3 class="text-xl font-bold mb-1">John Smith</h3>
                    <p class="text-gray-600 mb-3">CTO</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-gray-400 hover:text-yellow-600"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-gray-400 hover:text-yellow-600"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ asset('images/johny.webp') }}" alt="Mary Johnson" class="w-full h-64 object-cover">
                <div class="p-4 text-center">
                    <h3 class="text-xl font-bold mb-1">Mary Johnson</h3>
                    <p class="text-gray-600 mb-3">Head of Operations</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-gray-400 hover:text-yellow-600"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-gray-400 hover:text-yellow-600"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ asset('images/johny.webp') }}" alt="David Lee" class="w-full h-64 object-cover">
                <div class="p-4 text-center">
                    <h3 class="text-xl font-bold mb-1">David Lee</h3>
                    <p class="text-gray-600 mb-3">Customer Service Manager</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-gray-400 hover:text-yellow-600"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-gray-400 hover:text-yellow-600"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 