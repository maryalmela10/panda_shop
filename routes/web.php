<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;

// Página de inicio pública
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Página pública de la tienda
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/product/{producto}', [ProductoController::class, 'publicShow'])->name('shop.product');
Route::view('/about', 'customerViews.about')->name('about');
Route::view('/contact', 'customerViews.contact')->name('contact');

// Carrito y pedidos (requieren login)
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CarritoController::class, 'index'])->name('cart.index');
    Route::get('/cart/add/{productId}', [CarritoController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart/remove/{productId}', [CarritoController::class, 'removeFromCart'])->name('cart.remove');

    Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/{orderId}/confirmation', [OrderController::class, 'confirmation'])->name('order.confirmation');

    Route::get('/productos/{producto}/review', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/productos/{producto}/review', [ReviewController::class, 'store'])->name('reviews.store');

    });

// Panel del cliente (área protegida)
Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::get('/panel', [DashboardController::class, 'index'])->name('home');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });

Route::get('/dashboard', function () {
    return redirect()->route('dashboard.home');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
