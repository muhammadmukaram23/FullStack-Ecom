@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                <div class="py-4 px-6 bg-yellow-600 text-white">            <h2 class="text-2xl font-bold">Login to Your Account</h2>        </div>
        
        <form method="POST" action="{{ route('login') }}" class="py-6 px-8">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus                     class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600 @error('email') border-red-500 @enderror">
                
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                                <input type="password" id="password" name="password" required autocomplete="current-password"                     class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600 @error('password') border-red-500 @enderror">
                
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}                         class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                </div>
                
                <a href="#" class="text-sm text-yellow-600 hover:underline">Forgot password?</a>
            </div>
            
            <div class="mb-4">
                <button type="submit" class="w-full bg-yellow-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                    Login
                </button>
            </div>
            
            <div class="text-center">
                <p class="text-gray-600">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-yellow-600 hover:underline">Register now</a>
                </p>
            </div>
        </form>
    </div>
@endsection 