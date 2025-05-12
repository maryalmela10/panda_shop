<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class CarritoController extends Controller
{
    public function index()
    {
        // Obtener el carrito desde la sesión
        $cart = session()->get('cart', []);

        // Calcular el coste total
        $totalCost = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        // Pasar los productos del carrito y el coste total a la vista
        return view('carrito', compact('cart', 'totalCost'));
    }

    /**
     * Agregar un producto al carrito.
     */
    public function addToCart($productId)
    {
        $product = Producto::findOrFail($productId);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->nombre,
                'price' => $product->precio,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index');
    }

    /**
     * Eliminar un producto del carrito.
     */
    public function removeFromCart($productId)
    {
        // Obtener el carrito de la sesión
        $cart = session()->get('cart', []);

        // Verificar si el producto está en el carrito
        if (isset($cart[$productId])) {
            // Si la cantidad es mayor que 1, solo disminuimos la cantidad
            if ($cart[$productId]['quantity'] > 1) {
                $cart[$productId]['quantity']--;
            } else {
                // Si la cantidad es 1, eliminamos el producto del carrito
                unset($cart[$productId]);
            }

            // Actualizamos el carrito en la sesión
            session()->put('cart', $cart);
        }

        // Redirigir al carrito con un mensaje
        return redirect()->route('cart.index')->with('success', 'Producto actualizado en el carrito');
    }
}
