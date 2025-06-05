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

        // Array para guardar los productos 
        $cartItems = [];
        $totalCost = 0;

        foreach ($cart as $item) {
            $producto = Producto::find($item['id']);

            if ($producto) {
                $cartItems[] = [
                    'producto' => $producto, 
                    'quantity' => $item['quantity'],
                    'price' => $item['price'], 
                ];

                $totalCost += $item['price'] * $item['quantity'];
            }
        }

        return view('carrito', compact('cartItems', 'totalCost'));
    }

    /**
     * Agregar un producto al carrito.
     */
    public function addToCart($productId)
    {
        $product = Producto::findOrFail($productId);

        if (!$product->disponible || $product->stock <= 0) {
            return redirect()->route('shop')->with('error', 'Este producto no está disponible');
        }

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

        // Redirigir al carrito con un mensaje
        return redirect()->route('shop')->with('success', 'Producto agregado al carrito.');
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
            unset($cart[$productId]);
            
            // Actualizamos el carrito en la sesión
            session()->put('cart', $cart);
        }

        // Redirigir al carrito con un mensaje
        return redirect()->route('cart.index')->with('success', 'Producto actualizado en el carrito');
    }

    public function updateQuantity(Request $request, $id)
    {
        $quantity = max(1, (int) $request->input('quantity')); // mínimo 1

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Cantidad actualizada');
    }
}
