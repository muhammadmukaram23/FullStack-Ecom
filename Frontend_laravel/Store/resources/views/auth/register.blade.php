@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                <div class="py-4 px-6 bg-yellow-600 text-white">            <h2 class="text-2xl font-bold">Create an Account</h2>        </div>
        
        <form method="POST" action="{{ route('register') }}" class="py-6 px-8">
            @csrf
            
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600 @error('name') border-red-500 @enderror">
                
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600 @error('email') border-red-500 @enderror">
                
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="age" class="block text-gray-700 font-medium mb-2">Age</label>
                <input type="number" id="age" name="age" value="{{ old('age', 18) }}" required min="18" max="120"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600 @error('age') border-red-500 @enderror">
                
                @error('age')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <input type="password" id="password" name="password" required autocomplete="new-password" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600 @error('password') border-red-500 @enderror">
                
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="password-confirm" class="block text-gray-700 font-medium mb-2">Confirm Password</label>
                <input type="password" id="password-confirm" name="password_confirmation" required autocomplete="new-password" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600">
            </div>
            
            <div class="mb-4">
                <button type="submit" class="w-full bg-yellow-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                    Register
                </button>
            </div>
            
            <div class="text-center">
                <p class="text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-yellow-600 hover:underline">Login instead</a>
                </p>
            </div>
        </form>
    </div>
@endsection 