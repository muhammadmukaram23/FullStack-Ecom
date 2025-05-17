@extends('layouts.admin')

@section('title', 'Add New Product')
@section('subtitle', 'Create a new product in your catalog')

@section('content')
    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p class="font-bold">Form validation errors:</p>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <form action="{{ route('admin.products.store') }}" method="POST" class="p-6" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="product_name" class="block text-gray-700 font-medium mb-2">Product Name</label>
                    <input type="text" id="product_name" name="product_name" value="{{ old('product_name') }}" required 
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
                            <option value="{{ $category['category_id'] }}" {{ old('category_id') == $category['category_id'] ? 'selected' : '' }}>
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
                    <input type="number" step="0.01" min="0" id="product_price" name="product_price" value="{{ old('product_price') }}" required 
                        class="w-full pl-7 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('product_price') border-red-500 @enderror">
                </div>
                
                @error('product_price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="product_description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea id="product_description" name="product_description" rows="5" required 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('product_description') border-red-500 @enderror">{{ old('product_description') }}</textarea>
                
                @error('product_description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="product_images" class="block text-gray-700 font-medium mb-2">Product Images</label>
                <input type="file" id="product_images" name="product_images[]" multiple 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('product_images') border-red-500 @enderror"
                    accept="image/jpeg,image/png,image/gif,image/webp,image/jpg">
                
                @error('product_images')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                @error('product_images.*')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">You can select multiple images for your product (optional). Supported formats: JPG, PNG, GIF, WEBP</p>
            </div>
            
            <div class="flex items-center justify-end">
                <a href="{{ route('admin.products') }}" class="text-gray-700 mr-4">Cancel</a>
                <button type="submit" class="bg-blue-700 text-white py-2 px-4 rounded-lg hover:bg-blue-800">
                    <i class="fas fa-save mr-1"></i> Save Product
                </button>
            </div>
        </form>
    </div>
@endsection 