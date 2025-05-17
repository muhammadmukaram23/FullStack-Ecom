@extends('layouts.admin')

@section('title', 'Edit Category')
@section('subtitle', 'Update category information')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.categories') }}" class="text-blue-700 hover:text-blue-900">
            <i class="fas fa-arrow-left mr-1"></i> Back to Categories
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-800">Edit Category</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.categories.update', $category['category_id']) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="category_name" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                    <input type="text" name="category_name" id="category_name" value="{{ $category['category_name'] }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    @error('category_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection 