<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

Route::get('/', [PageController::class, 'showHome'])->name('home');
// register
Route::get('/register', [PageController::class, 'showRegister'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register.post');

// login
Route::get('/login', [PageController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.post');

Route::get('/categories', [PageController::class, 'showCategories'])->name('categories');

Route::get('/about', [PageController::class, 'showAbout'])->name('about');
Route::get('/contact', [PageController::class, 'showContact'])->name('contact');
Route::get('/detail/{id?}', [PageController::class, 'showDetail'])->name('detail');
// cart
Route::get('/cart', [PageController::class, 'showCart'])->name('cart');

// logout
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// cart routes
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');

// cart & checkout - yêu cầu đăng nhập
Route::middleware('auth')->group(function () {
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/order/success', [PageController::class, 'orderSuccess'])->name('order.success');
});

// Admin routes
require __DIR__.'/admin.php';

// Admin access route
Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'admin']);
