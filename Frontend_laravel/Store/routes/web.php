<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home and static pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{id}', [ProductController::class, 'byCategory'])->name('products.category');

// Cart (requires authentication)
Route::group(['middleware' => 'api.auth'], function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/update/{itemId}', [CartController::class, 'updateCartItem'])->name('cart.update');
    Route::delete('/cart/remove/{itemId}', [CartController::class, 'removeCartItem'])->name('cart.remove');
    
    // Checkout and orders
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
});

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [App\Http\Controllers\AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\AdminController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');
    
    // Admin protected routes
    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Products management
        Route::get('/products', [App\Http\Controllers\AdminController::class, 'products'])->name('admin.products');
        Route::get('/products/create', [App\Http\Controllers\AdminController::class, 'showProductForm'])->name('admin.products.create');
        Route::post('/products', [App\Http\Controllers\AdminController::class, 'createProduct'])->name('admin.products.store');
        Route::get('/products/{id}/edit', [App\Http\Controllers\AdminController::class, 'editProduct'])->name('admin.products.edit');
        Route::put('/products/{id}', [App\Http\Controllers\AdminController::class, 'updateProduct'])->name('admin.products.update');
        Route::delete('/products/{id}', [App\Http\Controllers\AdminController::class, 'deleteProduct'])->name('admin.products.delete');
        Route::post('/products/delete-image', [App\Http\Controllers\AdminController::class, 'deleteProductImage'])->name('admin.products.delete-image');
        
        // Categories management
        Route::get('/categories', [App\Http\Controllers\AdminController::class, 'categories'])->name('admin.categories');
        Route::get('/categories/create', [App\Http\Controllers\AdminController::class, 'showCategoryForm'])->name('admin.categories.create');
        Route::post('/categories', [App\Http\Controllers\AdminController::class, 'createCategory'])->name('admin.categories.store');
        Route::get('/categories/{id}/edit', [App\Http\Controllers\AdminController::class, 'editCategory'])->name('admin.categories.edit');
        Route::put('/categories/{id}', [App\Http\Controllers\AdminController::class, 'updateCategory'])->name('admin.categories.update');
        Route::delete('/categories/{id}', [App\Http\Controllers\AdminController::class, 'deleteCategory'])->name('admin.categories.delete');
        
        // Orders management
        Route::get('/orders', [App\Http\Controllers\AdminController::class, 'orders'])->name('admin.orders');
        Route::get('/orders/{id}', [App\Http\Controllers\AdminController::class, 'viewOrder'])->name('admin.orders.view');
        
        // Contacts management
        Route::get('/contacts', [App\Http\Controllers\AdminController::class, 'contacts'])->name('admin.contacts');
        
        // Users management
        Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
        Route::delete('/users/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('admin.users.delete');
    });
});

