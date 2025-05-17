@extends('layouts.admin')

@section('title', 'Add New Category')
@section('subtitle', 'Create a new product category')

@section('content')
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <form action="{{ route('admin.categories.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="mb-6">
                <label for="category_name" class="block text-gray-700 font-medium mb-2">Category Name</label>
                <input type="text" id="category_name" name="category_name" value="{{ old('category_name') }}" required 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('category_name') border-red-500 @enderror">
                
                @error('category_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center justify-end">
                <a href="{{ route('admin.categories') }}" class="text-gray-700 mr-4">Cancel</a>
                <button type="submit" class="bg-blue-700 text-white py-2 px-4 rounded-lg hover:bg-blue-800">
                    <i class="fas fa-save mr-1"></i> Save Category
                </button>
            </div>
        </form>
    </div>
@endsection 