<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index()
    {
        // Asegurarse de que el usuario está autenticado
        $usuario = auth()->user();

        if (!$usuario) {
            abort(403, 'Debes iniciar sesión para ver tus pedidos.');
        }

        // Obtener pedidos del usuario con detalles relacionados
        $pedidos = Pedido::where('usuario_id', $usuario->id)
            ->with(['productos', 'productos.categoria'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('pedidos.index', compact('pedidos'));
    }
    // Mostrar el formulario de pedido
    public function create()
    {
        // Obtener los productos del carrito desde la sesión
        $cart = session()->get('cart', []);
        $totalCost = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('pedidos.create', compact('cart', 'totalCost'));
    }

    // Almacenar el pedido en la base de datos
    public function store(Request $request)
    {
        // Obtener el carrito de la sesión
        $cart = session('cart', []);

        // Calcular el coste total de los productos
        $totalCost = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        // Lógica para el coste de envío según el total de los productos
        if ($totalCost >= 100) {
            $costeEnvio = 0;
        } elseif ($totalCost >= 50) {
            $costeEnvio = 5;
        } else {
            $costeEnvio = 10;
        }

        // Otros datos del pedido
        $order = new Pedido();
        $order->usuario_id = auth()->user()->id;
        $order->metodo_pago = $request->metodo_pago;
        $order->coste_envio = $costeEnvio;
        $order->direccion_envio = $request->direccion_envio;
        $order->fecha_pedido = now();
        $order->save();

        // Relacionar los productos con la orden y actualizar stock
        foreach ($cart as $item) {
            // Asociar el producto al pedido
            $order->productos()->attach($item['id'], [
                'cantidad' => $item['quantity'],
                'precio' => $item['price'],
            ]);

            // Actualizar el stock del producto
            $producto = Producto::find($item['id']);
            if ($producto) {
                $producto->stock = max(0, $producto->stock - $item['quantity']); // Evita negativos
                $producto->save();
            }
        }


        session()->forget('cart');

        // Redirigir a la confirmación con el total del pedido
        return redirect()->route('pedidos.resume', ['orderId' => $order->id])
                        ->with('totalCost', $totalCost);
    }

    // Mostrar la confirmación del pedido
    public function resume($orderId)
    {
        $order = Pedido::with('productos')->findOrFail($orderId);

        // Calcular total productos desde la relación en BD
        $totalProductos = $order->productos->sum(function ($producto) {
            return $producto->pivot->precio * $producto->pivot->cantidad;
        });

        return view('pedidos.resume', compact('order', 'totalProductos'));
    }

}
