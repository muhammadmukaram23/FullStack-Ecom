<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }
        .login-container {
            min-height: 100vh;
        }
        .brand-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }
        .input-focus-effect:focus-within {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }
    </style>
</head>
<body>
    <div class="login-container flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <!-- Login Header -->
                <div class="brand-gradient p-8 text-white text-center">
                    <div class="flex justify-center mb-3">
                        <div class="h-16 w-16 rounded-full bg-white bg-opacity-15 flex items-center justify-center">
                            <i class="fas fa-store text-3xl"></i>
                        </div>
                    </div>
                    <h1 class="text-2xl font-bold mb-1">Admin Panel</h1>
                    <p class="text-blue-100 text-sm">Enter your credentials to login</p>
                </div>
                
                <!-- Login Form -->
                <div class="p-8">
                    @if(session('error'))
                        <div class="mb-6 bg-red-50 text-red-600 p-4 rounded-lg flex items-start">
                            <i class="fas fa-exclamation-circle mt-1 mr-3"></i>
                            <span class="text-sm">{{ session('error') }}</span>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                            <div class="relative rounded-md input-focus-effect transition-all duration-200 border border-gray-300 focus-within:border-blue-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" id="username" name="username" required 
                                    class="block w-full pl-10 pr-3 py-3 text-gray-900 placeholder-gray-400 border-0 focus:outline-none focus:ring-0 sm:text-sm rounded-md"
                                    placeholder="Enter your username">
                            </div>
                            @error('username')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <div class="relative rounded-md input-focus-effect transition-all duration-200 border border-gray-300 focus-within:border-blue-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" id="password" name="password" required 
                                    class="block w-full pl-10 pr-3 py-3 text-gray-900 placeholder-gray-400 border-0 focus:outline-none focus:ring-0 sm:text-sm rounded-md"
                                    placeholder="Enter your password">
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-6 text-center">
                        <a href="{{ route('home') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-1"></i> Back to Website
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-6 text-xs text-gray-500">
                &copy; {{ date('Y') }} E-commerce Store. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html> 