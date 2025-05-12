<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CarritoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cart', [CarritoController::class, 'index'])->name('cart.index');
    Route::get('/cart/add/{productId}', [CarritoController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart/remove/{productId}', [CarritoController::class, 'removeFromCart'])->name('cart.remove');

    Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/{orderId}/confirmation', [OrderController::class, 'confirmation'])->name('order.confirmation');
});

require __DIR__.'/auth.php';
