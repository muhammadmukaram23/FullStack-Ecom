@extends('layouts.app')

@section('title', isset($product) ? $product['product_name'] : 'Product Details')

@section('content')
    <div class="container mx-auto px-4 py-8">
        @if(isset($product))
            <!-- Breadcrumbs -->
            <nav class="text-sm mb-8">
                <ol class="list-none p-0 flex flex-wrap items-center">
                    <li class="flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary-600">Home</a>
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-primary-600">Products</a>
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                    </li>
                    <li class="text-gray-700 font-medium truncate">{{ $product['product_name'] }}</li>
                </ol>
            </nav>
            
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
                    <!-- Product Images -->
                    <div class="p-6 md:border-r border-gray-100">
                        <div class="mb-4 border rounded-lg overflow-hidden bg-gray-50 flex items-center justify-center h-96">
                            @if(isset($images) && count($images) > 0)
                                <img id="main-product-image" src="{{ $images[0]['image_url'] }}" alt="{{ $product['product_name'] }}" class="max-w-full max-h-full object-contain p-4">
                            @else
                                <img src="https://via.placeholder.com/600x400" alt="{{ $product['product_name'] }}" class="max-w-full max-h-full object-contain p-4">
                            @endif
                        </div>
                        
                        <!-- Image Thumbnails -->
                        @if(isset($images) && count($images) > 0)
                            <div class="grid grid-cols-5 gap-2">
                                @foreach($images as $index => $image)
                                    <div class="border rounded cursor-pointer hover:border-primary-600 thumbnail-image p-1 bg-white transition duration-200" data-image-url="{{ $image['image_url'] }}">
                                        <img src="{{ $image['image_url'] }}" alt="{{ $product['product_name'] }}" class="w-full h-16 object-contain">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    <!-- Product Details -->
                    <div class="p-6">
                        <div class="mb-4">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">In Stock</span>
                                <div class="flex items-center text-yellow-400 text-sm">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="text-gray-500 ml-1">(29 reviews)</span>
                                </div>
                            </div>
                            <h1 class="text-3xl font-bold mb-2">{{ $product['product_name'] }}</h1>
                            <p class="text-gray-600 mb-4">Product ID: {{ $product['product_id'] }}</p>
                        </div>
                        
                        <div class="text-2xl font-bold text-gray-800 mb-4">
                            ${{ number_format($product['product_price'], 2) }}
                        </div>
                        
                        <div class="mb-6">
                            <p class="text-gray-700 leading-relaxed">{{ $product['product_description'] }}</p>
                        </div>
                        
                        <!-- Color Options (Sample) -->
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-900 mb-2">Color</h3>
                            <div class="flex items-center space-x-3">
                                <button class="w-8 h-8 rounded-full bg-gray-800 ring-2 ring-gray-800 ring-offset-1 focus:outline-none"></button>
                                <button class="w-8 h-8 rounded-full bg-blue-600 focus:outline-none"></button>
                                <button class="w-8 h-8 rounded-full bg-red-600 focus:outline-none"></button>
                                <button class="w-8 h-8 rounded-full bg-green-600 focus:outline-none"></button>
                            </div>
                        </div>
                        
                        <!-- Add to Cart Form -->
                        <form action="{{ route('cart.add') }}" method="POST" class="mb-6">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product['product_id'] }}">
                            
                            <div class="flex items-center mb-6">
                                <label for="quantity" class="mr-4 font-medium">Quantity:</label>
                                <div class="flex h-10 w-32">
                                    <button type="button" class="flex-1 flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-l-md" onclick="decrementQuantity()">
                                        <i class="fas fa-minus text-xs"></i>
                                    </button>
                                    <input type="number" id="quantity" name="quantity" value="1" min="1" class="flex-1 w-full text-center border-t border-b focus:outline-none focus:ring-0 focus:border-gray-300 text-gray-700">
                                    <button type="button" class="flex-1 flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-r-md" onclick="incrementQuantity()">
                                        <i class="fas fa-plus text-xs"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-6 rounded-md transition flex items-center justify-center">
                                    <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                                </button>
                                
                                <button type="button" class="border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 font-medium py-3 px-6 rounded-md transition flex items-center justify-center">
                                    <i class="far fa-heart mr-2"></i> Add to Wishlist
                                </button>
                            </div>
                        </form>
                        
                        <!-- Additional Information -->
                        <div class="border-t pt-6 space-y-4">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-truck-moving text-primary-600 mr-2 w-5 text-center"></i>
                                <span>Free shipping on orders over $50</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-undo text-primary-600 mr-2 w-5 text-center"></i>
                                <span>30-day hassle-free return policy</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-shield-alt text-primary-600 mr-2 w-5 text-center"></i>
                                <span>Secure checkout with SSL encryption</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-tag text-primary-600 mr-2 w-5 text-center"></i>
                                <span>Authentic products guaranteed</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Product Tabs -->
            <div class="mt-12">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px space-x-8">
                        <button class="border-b-2 border-primary-600 py-4 px-1 text-sm font-medium text-primary-600 whitespace-nowrap">
                            Description
                        </button>
                        <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                            Specifications
                        </button>
                        <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                            Reviews (29)
                        </button>
                    </nav>
                </div>
                
                <div class="py-8">
                    <h2 class="text-lg font-bold mb-4">Product Description</h2>
                    <div class="prose max-w-none text-gray-700">
                        <p>{{ $product['product_description'] }}</p>
                        
                        <!-- Placeholder content for the detailed description -->
                        <p class="mt-4">
                            Experience superior quality and performance with our premium product designed to exceed your expectations. 
                            Crafted with precision and attention to detail, this product offers:
                        </p>
                        
                        <ul class="list-disc pl-6 mt-2 space-y-1">
                            <li>Premium materials for lasting durability</li>
                            <li>Ergonomic design for comfort and ease of use</li>
                            <li>Innovative features that set it apart from the competition</li>
                            <li>Versatile functionality for various applications</li>
                            <li>Eco-friendly manufacturing process</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Related Products Section -->
            <!-- <div class="mt-12">
                <h2 class="text-2xl font-bold mb-6">You May Also Like</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    @for($i = 0; $i < 4; $i++)
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 card-hover">
                            <a href="#">
                                <div class="relative h-48 overflow-hidden">
                                    <img src="https://via.placeholder.com/300x300" alt="Related Product" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                                </div>
                            </a>
                            <div class="p-4">
                                <a href="#" class="block">
                                    <h3 class="font-semibold hover:text-primary-600 transition">Related Product {{ $i + 1 }}</h3>
                                </a>
                                <p class="text-gray-600 text-sm mt-1 mb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <div class="flex justify-between items-center mt-auto">
                                    <span class="font-bold text-gray-800">$49.99</span>
                                    <button class="bg-primary-600 text-white p-2 rounded-full hover:bg-primary-700">
                                        <i class="fas fa-shopping-cart text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div> -->
        @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <div class="text-gray-500 mb-6">
                    <i class="fas fa-exclamation-circle text-6xl mb-4"></i>
                    <h1 class="text-2xl font-bold mb-2">Product Not Found</h1>
                    <p class="text-gray-500 mb-6">The product you're looking for doesn't exist or has been removed.</p>
                </div>
                <a href="{{ route('products.index') }}" class="bg-primary-600 text-white font-medium px-6 py-3 rounded-md hover:bg-primary-700 inline-block">
                    Browse Products
                </a>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
    // Image gallery functionality
    document.addEventListener('DOMContentLoaded', function() {
        const thumbnails = document.querySelectorAll('.thumbnail-image');
        const mainImage = document.getElementById('main-product-image');
        
        if (thumbnails.length > 0 && mainImage) {
            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', function() {
                    const imageUrl = this.getAttribute('data-image-url');
                    mainImage.src = imageUrl;
                    
                    // Remove active class from all thumbnails
                    thumbnails.forEach(t => t.classList.remove('border-primary-600', 'border-2'));
                    
                    // Add active class to clicked thumbnail
                    this.classList.add('border-primary-600', 'border-2');
                });
            });
            
            // Set the first thumbnail as active by default
            if (thumbnails.length > 0) {
                thumbnails[0].classList.add('border-primary-600', 'border-2');
            }
        }
    });
    
    function incrementQuantity() {
        const quantityInput = document.getElementById('quantity');
        quantityInput.value = parseInt(quantityInput.value) + 1;
    }
    
    function decrementQuantity() {
        const quantityInput = document.getElementById('quantity');
        const currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    }
</script>
@endsection
 