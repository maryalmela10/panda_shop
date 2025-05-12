<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Mostrar el formulario de pedido
    public function create()
    {
        // Obtener los productos del carrito desde la sesión
        $cart = session()->get('cart', []);
        $totalCost = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('pedido', compact('cart', 'totalCost'));
    }

    // Almacenar el pedido en la base de datos
    public function store(Request $request)
    {
        // Obtener el carrito de la sesión
        $cart = session('cart', []);

        // Calcular el coste total de los productos
        $totalCost = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        // Lógica para el coste de envío según el total de los productos
        if ($totalCost > 100) {
            $costeEnvio = 0;  // Envío gratis
        } elseif ($totalCost > 50) {
            $costeEnvio = 5;  // Envío a 5$
        } else {
            $costeEnvio = 10;  // Envío a 10$
        }

        // Otros datos del pedido
        $order = new Orden();
        $order->usuario_id = auth()->user()->id;
        $order->metodo_pago = $request->metodo_pago;
        $order->coste_envio = $costeEnvio;  // Asignar el coste de envío calculado
        $order->direccion_envio = $request->direccion_envio;
        $order->fecha_pedido = now();
        $order->save();

        // Relacionar los productos con la orden
        foreach ($cart as $item) {
            $order->productos()->attach($item['id'], [
                'cantidad' => $item['quantity'],
                'precio' => $item['price'],
            ]);
        }

        session()->forget('cart');

        // Redirigir a la confirmación con el total del pedido
        return redirect()->route('order.confirmation', ['orderId' => $order->id])
                        ->with('totalCost', $totalCost);
    }

    // Mostrar la confirmación del pedido
    public function confirmation($orderId)
    {
        // Obtén el pedido de la base de datos
        $order = Orden::findOrFail($orderId);

        // Suma el total de los productos en el carrito
        $totalCost = collect(session('cart'))->sum(fn($item) => $item['price'] * $item['quantity']);

        // Redirigir a la vista de confirmación del pedido con el pedido y el costo total
        return view('confirmacionPedido', compact('order', 'totalCost'));
    }
}
