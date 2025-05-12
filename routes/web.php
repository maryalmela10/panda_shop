<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::view('/shop', 'customerViews.shop')->name('shop');
Route::view('/shop/product', 'customerViews.shop-single')->name('shop.product');
Route::view('/about', 'customerViews.about')->name('about');
Route::view('/contact', 'customerViews.contact')->name('contact');

require __DIR__.'/auth.php';
