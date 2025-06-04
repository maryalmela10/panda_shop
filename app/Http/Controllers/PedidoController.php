<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\PedidoResumenMail;
use Illuminate\Support\Facades\Mail;

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
        $cart = session()->get('cart', []);
        $cartWithProducts = [];

        foreach ($cart as $item) {
            $producto = Producto::find($item['id']);
            if ($producto) {
                $cartWithProducts[] = [
                    'producto' => $producto,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                ];
            }
        }

        $totalCost = collect($cartWithProducts)->sum(fn($item) => $item['price'] * $item['quantity']);
        $intent = auth()->user()->createSetupIntent();

        return view('pedidos.create', [
            'cart' => $cartWithProducts,
            'totalCost' => $totalCost,
            'intent' => $intent
        ]);
    }


    // Almacenar el pedido en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'metodo_pago' => 'required',
            'direccion_envio' => 'required|string',
            'payment_method' => 'required_if:metodo_pago,tarjeta',
            'justificante_pago' => 'nullable|required_if:metodo_pago,transferencia|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'fecha_transferencia' => 'nullable|required_if:metodo_pago,transferencia|date',
        ], [
            'metodo_pago.required' => 'Por favor, selecciona un método de pago.',
            'direccion_envio.required' => 'La dirección de envío es obligatoria.',
            'payment_method.required_if' => 'Debes introducir los datos de tu tarjeta.',
            'justificante_pago.required_if' => 'Debes subir el justificante de pago para transferencias.',
            'justificante_pago.file' => 'El justificante debe ser un archivo válido.',
            'justificante_pago.mimes' => 'Solo se permiten archivos PDF, JPG, JPEG o PNG.',
            'justificante_pago.max' => 'El justificante no debe pesar más de 2MB.',
            'fecha_transferencia.required_if' => 'Debes indicar la fecha en la que realizaste la transferencia.',
            'fecha_transferencia.date' => 'La fecha de transferencia debe tener un formato válido.',
        ]);

        // Obtener el carrito de la sesión
        $cart = session('cart', []);

        // Calcular el coste total de los productos
        $totalCost = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        // Calcular coste de envío según total de productos
        $costeEnvio = match (true) {
            $totalCost >= 100 => 0,
            $totalCost >= 50 => 5,
            default => 10,
        };

        $user = auth()->user();
        $totalPagado = $totalCost + $costeEnvio;

        // Si es tarjeta, cobrar con Stripe
        if ($request->metodo_pago === 'tarjeta') {
            $user->createOrGetStripeCustomer();
            $user->addPaymentMethod($request->payment_method);
            $user->charge($totalPagado * 100, $request->payment_method, [
                'return_url' => route('pedidos.resume', ['orderId' => 'dummy'])
            ]);
        }

        // Crear el pedido
        $order = new Pedido();
        $order->usuario_id = $user->id;
        $order->metodo_pago = $request->metodo_pago;
        $order->coste_envio = $costeEnvio;
        $order->direccion_envio = $request->direccion_envio;
        $order->fecha_pedido = now();
        $order->total_pagado = $totalPagado;

        if ($request->metodo_pago === 'transferencia') {
            if ($request->hasFile('justificante_pago')) {
                $archivo = $request->file('justificante_pago');
                $nombreArchivo = hash('sha256', time() . $archivo->getClientOriginalName()) . '.' . $archivo->getClientOriginalExtension();
                $archivo->move(public_path('justificantes'), $nombreArchivo);
                $order->justificante_pago = 'justificantes/' . $nombreArchivo;
            }
            $order->fecha_transferencia = $request->fecha_transferencia;
            $order->estado = 'pendiente'; // Esperando confirmación
        } elseif ($request->metodo_pago === 'tarjeta') {
            $order->estado = 'confirmado'; // Pagado directamente
        } else {
            $order->estado = 'pendiente'; // PayPal / contra-reembolso
        }
        $order->save();

        // Asociar productos y actualizar stock/ventas
        foreach ($cart as $item) {
            $order->productos()->attach($item['id'], [
                'cantidad' => $item['quantity'],
                'precio_producto' => $item['price'],
            ]);

            $producto = Producto::find($item['id']);
            if ($producto) {
                $producto->stock = max(0, $producto->stock - $item['quantity']);
                $producto->num_ventas += $item['quantity'];
                $producto->save();
            }
        }

        // Enviar resumen por correo
        Mail::to($user->email)->send(new PedidoResumenMail($order, $cart, $totalCost));

        // Limpiar carrito
        session()->forget('cart');

        // Redirigir con resumen
        return redirect()->route('pedidos.resume', ['orderId' => $order->id])
            ->with([
                'totalCost' => $totalCost,
                'success' => 'Se te ha enviado un resumen del pedido a tu correo'
            ]);
    }


    // Mostrar la confirmación del pedido
    public function resume($orderId)
    {
        $order = Pedido::with('productos')->findOrFail($orderId);

        // Calcular total productos desde la relación en BD
        $totalProductos = $order->productos->sum(function ($producto) {
            return $producto->pivot->precio_producto * $producto->pivot->cantidad;
        });

        return view('pedidos.resume', compact('order', 'totalProductos'));
    }
}
