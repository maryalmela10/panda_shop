<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Auth\PasswordController;


// Página de inicio pública
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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

    Route::get('/pedidos/create', [PedidoController::class, 'create'])->name('pedidos.create');
    Route::get('/mis-pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::get('/pedidos/{orderId}/resume', [PedidoController::class, 'resume'])->name('pedidos.resume');

    Route::get('/productos/{producto}/review', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/productos/{producto}/review', [ReviewController::class, 'store'])->name('reviews.store');
    });

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Productos
    Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{producto}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{producto}/update', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');

    // Categorías
    Route::get('/categorias/create', [CategoriaController::class, 'create'])->name('categorias.create');
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::get('/categorias/{categoria}/edit', [CategoriaController::class, 'edit'])->name('categorias.edit');
    Route::put('/categorias/{categoria}/update', [CategoriaController::class, 'update'])->name('categorias.update');
    Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
});


// Panel del cliente (área protegida)
Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::get('/panel', [DashboardController::class, 'index'])->name('home');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::put('/password/update', [PasswordController::class, 'update'])->name('password.update');
    });

Route::get('/dashboard', function () {
    return redirect()->route('dashboard.home');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
