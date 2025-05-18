@extends('layouts.admin')

@section('title', 'Edit Product')
@section('subtitle', 'Update product information')

@section('content')
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <form action="{{ route('admin.products.update', $product['product_id']) }}" method="POST" class="p-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="product_name" class="block text-gray-700 font-medium mb-2">Product Name</label>
                    <input type="text" id="product_name" name="product_name" value="{{ old('product_name', $product['product_name']) }}" required 
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('product_name') border-red-500 @enderror">
                    
                    @error('product_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="category_id" class="block text-gray-700 font-medium mb-2">Category</label>
                    <select id="category_id" name="category_id" required 
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('category_id') border-red-500 @enderror">
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category['category_id'] }}" {{ old('category_id', $product['category_id']) == $category['category_id'] ? 'selected' : '' }}>
                                {{ $category['category_name'] }}
                            </option>
                        @endforeach
                    </select>
                    
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mb-6">
                <label for="product_price" class="block text-gray-700 font-medium mb-2">Price</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                    <input type="number" step="0.01" min="0" id="product_price" name="product_price" value="{{ old('product_price', $product['product_price']) }}" required 
                        class="w-full pl-7 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('product_price') border-red-500 @enderror">
                </div>
                
                @error('product_price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="product_description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea id="product_description" name="product_description" rows="5" required 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('product_description') border-red-500 @enderror">{{ old('product_description', $product['product_description']) }}</textarea>
                
                @error('product_description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Current Images -->
            @if(isset($product['images']) && count($product['images']) > 0)
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Current Images</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($product['images'] as $image)
                            <div class="relative group">
                                <img src="{{ $image['image_url'] }}" alt="Product Image" class="w-full h-40 object-cover rounded-lg">
                                <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                                    <button type="button" class="delete-image-btn text-white bg-red-600 hover:bg-red-700 rounded-full p-2"
                                        data-image-id="{{ $image['image_id'] }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-gray-500 text-sm mt-1">Hover over an image and click the trash icon to delete</p>
                </div>
            @endif
            
            <!-- Upload New Images -->
            <div class="mb-6">
                <label for="new_images" class="block text-gray-700 font-medium mb-2">Add More Images</label>
                <input type="file" id="new_images" name="new_images[]" multiple 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('new_images') border-red-500 @enderror"
                    accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                
                @error('new_images')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                @error('new_images.*')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">You can select multiple images to add (JPG, PNG, GIF, WebP)</p>
            </div>
            
            <div class="flex items-center justify-end">
                <a href="{{ route('admin.products') }}" class="text-gray-700 mr-4">Cancel</a>
                <button type="submit" class="bg-blue-700 text-white py-2 px-4 rounded-lg hover:bg-blue-800">
                    <i class="fas fa-save mr-1"></i> Update Product
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-image-btn');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const imageId = this.getAttribute('data-image-id');
                const confirmed = confirm('Are you sure you want to delete this image?');
                
                if (confirmed) {
                    // Send AJAX request to delete image
                    fetch('{{ route("admin.products.delete-image") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ image_id: imageId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove the image container
                            this.closest('.relative').remove();
                        } else {
                            alert('Failed to delete image: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the image');
                    });
                }
            });
        });
    });
</script>
@endsection 