<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;


// Página de inicio pública
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Página pública de la tienda
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::view('/shop/product', 'customerViews.shop-single')->name('shop.product');
Route::view('/about', 'customerViews.about')->name('about');
Route::view('/contact', 'customerViews.contact')->name('contact');

// Rutas de autenticación (si no estás usando laravel/ui o breeze/jetstream)
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Rutas para la verificación de correo electrónico
Route::get('/email/verify', [RegisterController::class, 'showVerificationNotice'])
    ->name('verification.notice');
Route::get('/verify-email/{token}', [RegisterController::class, 'verify'])
    ->name('verification.verify');
Route::post('/email/verification-notification', [RegisterController::class, 'resendVerificationEmail'])
    ->name('verification.resend');

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

    Route::get('/productos/{producto}', [ProductoController::class, 'show'])->name('productos.show');
});

// Panel del cliente (área protegida que requiere verificación de correo)
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