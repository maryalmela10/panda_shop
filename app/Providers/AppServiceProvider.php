<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Inyectar cantidad del carrito a todas las vistas
        View::composer('*', function ($view) {
            $cart = session('cart', []);
            $cantidad = array_sum(array_column($cart, 'quantity'));
            $view->with('carritoCantidad', $cantidad);
        });
    }
}
