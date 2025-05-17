@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <!-- Hero Section -->
    <div class="bg-yellow-600 text-white rounded-lg shadow-lg overflow-hidden mb-12" style="color: white; padding: 10px; text-align: center;">
        <div class="container mx-auto px-4 py-16" >
            <div class="max-w-3xl mx-auto text-center" >
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Contact Us</h1>
                <p class="text-xl">Have questions or feedback? We'd love to hear from you!</p>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Contact Form - 2/3 width on large screens -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-8">
                    <h2 class="text-2xl font-bold mb-6">Send Us a Message</h2>
                    
                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                                                <label for="name" class="block text-gray-700 font-medium mb-2">Your Name</label>                                <input type="text" id="name" name="name" value="{{ old('name') }}" required                                     class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600 @error('name') border-red-500 @enderror">
                                
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                                                <label for="email" class="block text-gray-700 font-medium mb-2">Your Email</label>                                <input type="email" id="email" name="email" value="{{ old('email') }}" required                                     class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600 @error('email') border-red-500 @enderror">
                                
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label for="subject" class="block text-gray-700 font-medium mb-2">Subject</label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required 
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600 @error('subject') border-red-500 @enderror">
                            
                            @error('subject')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-6">
                            <label for="message" class="block text-gray-700 font-medium mb-2">Your Message</label>
                            <textarea id="message" name="message" rows="6" required 
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                            
                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <button type="submit" class="bg-yellow-600 text-white font-medium py-3 px-6 rounded-md hover:bg-yellow-700 transition">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Contact Information - 1/3 width on large screens -->
        <div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="p-8">
                    <h2 class="text-2xl font-bold mb-6">Contact Information</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="bg-yellow-100 rounded-full p-3 mr-4">
                                <i class="fas fa-map-marker-alt text-yellow-600"></i>
                            </div>
                            <div>
                                <h3 class="font-bold mb-1">Address</h3>
                                <p class="text-gray-600">123 Main Street, Anytown, ST 12345</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-yellow-100 rounded-full p-3 mr-4">
                                <i class="fas fa-phone text-yellow-600"></i>
                            </div>
                            <div>
                                <h3 class="font-bold mb-1">Phone</h3>
                                <p class="text-gray-600">+1 (555) 123-4567</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-yellow-100 rounded-full p-3 mr-4">
                                <i class="fas fa-envelope text-yellow-600"></i>
                            </div>
                            <div>
                                <h3 class="font-bold mb-1">Email</h3>
                                <p class="text-gray-600">info@estore.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-yellow-100 rounded-full p-3 mr-4">
                                <i class="fas fa-clock text-yellow-600"></i>
                            </div>
                            <div>
                                <h3 class="font-bold mb-1">Business Hours</h3>
                                <p class="text-gray-600">Monday - Friday: 9am - 5pm</p>
                                <p class="text-gray-600">Saturday: 10am - 2pm</p>
                                <p class="text-gray-600">Sunday: Closed</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-8">
                    <h2 class="text-2xl font-bold mb-6">Follow Us</h2>
                    
                    <div class="flex space-x-4">
                        <a href="#" class="bg-yellow-600 text-white p-3 rounded-full hover:bg-yellow-700">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="bg-yellow-600 text-white p-3 rounded-full hover:bg-yellow-700">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="bg-yellow-600 text-white p-3 rounded-full hover:bg-yellow-700">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="bg-yellow-600 text-white p-3 rounded-full hover:bg-yellow-700">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Map Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-12">
        <div class="p-8">
            <h2 class="text-2xl font-bold mb-6">Our Location</h2>
            
            <div class="h-96 bg-gray-200 rounded-lg">
                <!-- Embed Google Maps or other map service here -->
                <div class="w-full h-full flex items-center justify-center text-gray-500">
                    <p>Map Embed Placeholder</p>
                </div>
            </div>
        </div>
    </div>
@endsection 