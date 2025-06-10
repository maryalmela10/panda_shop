<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PedidoResumenMail;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PedidoController extends Controller
{
    public function index()
    {
        $usuario = auth()->user();

        abort_unless($usuario, 403, 'Debes iniciar sesión para ver tus pedidos.');

        $pedidos = Pedido::where('usuario_id', $usuario->id)
            ->with(['productos', 'productos.categoria'])
            ->latest('id')
            ->paginate(10);

        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $cart = session('cart', []);
        $cartWithProducts = collect($cart)->map(function ($item) {
            $producto = Producto::find($item['id']);
            if ($producto) {
                return [
                    'producto' => $producto,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                ];
            }
            return null;
        })->filter();

        $totalCost = $cartWithProducts->sum(fn($item) => $item['price'] * $item['quantity']);
        $envio = $totalCost < 50 ? 10 : ($totalCost < 100 ? 5 : 0);
        $totalPagado = $totalCost + $envio;

        Stripe::setApiKey(config('services.stripe.secret'));
        $intent = PaymentIntent::create([
            'amount' => $totalPagado * 100,
            'currency' => 'eur',
            'metadata' => [
                'user_id' => auth()->id(),
                'email' => auth()->user()->email,
            ]
        ]);

        return view('pedidos.create', [
            'cart' => $cartWithProducts,
            'totalCost' => $totalCost,
            'intent' => $intent,
            'stripePublicKey' => config('services.stripe.key')
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'metodo_pago' => 'required',
            'direccion_envio' => [
                'required', 'string', 'min:10',
                'regex:/^C\/[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+,\s*\d+$/'
            ],
            'payment_method_id' => 'required_if:metodo_pago,tarjeta',
            'justificante_pago' => 'nullable|required_if:metodo_pago,transferencia|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'fecha_transferencia' => [
                'nullable', 'required_if:metodo_pago,transferencia', 'date',
                function ($attribute, $value, $fail) {
                    $fecha = Carbon::parse($value);
                    if ($fecha->lt(now()->subDays(5)) || $fecha->gt(now())) {
                        $fail('La fecha de transferencia debe estar entre hoy y hace 5 días.');
                    }
                }
            ],
        ], [
            'direccion_envio.regex' => 'La dirección debe tener el formato: C/NombreCalle, número (ejemplo: C/Alcalá, 12).',
            'payment_method.required_if' => 'Debes introducir los datos de tu tarjeta.',
            'justificante_pago.required_if' => 'Debes subir el justificante de pago para transferencias.',
            'justificante_pago.file' => 'El justificante debe ser un archivo válido.',
            'justificante_pago.mimes' => 'Solo se permiten archivos PDF, JPG, JPEG o PNG.',
            'justificante_pago.max' => 'El justificante no debe pesar más de 2MB.',
        ]);

        $cart = session('cart', []);
        $user = auth()->user();

        $totalCost = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $costeEnvio = $totalCost >= 100 ? 0 : ($totalCost >= 50 ? 5 : 10);
        $totalPagado = $totalCost + $costeEnvio;

        $pedido = new Pedido([
            'usuario_id' => $user->id,
            'metodo_pago' => $request->metodo_pago,
            'coste_envio' => $costeEnvio,
            'direccion_envio' => $request->direccion_envio,
            'fecha_pedido' => now(),
            'total_pagado' => $totalPagado,
        ]);

        if ($request->metodo_pago === 'transferencia') {
            if ($request->hasFile('justificante_pago')) {
                $archivo = $request->file('justificante_pago');
                $nombre = hash('sha256', time() . $archivo->getClientOriginalName()) . '.' . $archivo->getClientOriginalExtension();
                $archivo->move(public_path('justificantes'), $nombre);
                $pedido->justificante_pago = 'justificantes/' . $nombre;
            }

            $pedido->fecha_transferencia = $request->fecha_transferencia;
            $pedido->estado = 'pendiente';
        } elseif ($request->metodo_pago === 'tarjeta') {
            $pedido->estado = 'confirmado';
        } else {
            $pedido->estado = 'pendiente';
        }

        $pedido->save();

        foreach ($cart as $item) {
            $pedido->productos()->attach($item['id'], [
                'cantidad' => $item['quantity'],
                'precio_producto' => $item['price'],
            ]);

            Producto::where('id', $item['id'])->update([
                'stock' => DB::raw("GREATEST(stock - {$item['quantity']}, 0)"),
                'num_ventas' => DB::raw("num_ventas + {$item['quantity']}")
            ]);
        }

        Mail::to($user->email)->send(new PedidoResumenMail($pedido, $cart, $totalCost));
        session()->forget('cart');

        return redirect()->route('pedidos.resume', $pedido->id)
            ->with([
                'totalCost' => $totalCost,
                'success' => 'Se te ha enviado un resumen del pedido a tu correo.'
            ]);
    }

    public function resume($orderId)
    {
        $order = Pedido::with('productos')->findOrFail($orderId);
        $totalProductos = $order->productos->sum(fn($producto) =>
            $producto->pivot->precio_producto * $producto->pivot->cantidad
        );

        return view('pedidos.resume', compact('order', 'totalProductos'));
    }

    // ADMIN

    public function index_admin(Request $request)
    {
        $query = Pedido::with('usuario');

        if ($request->filled('busqueda')) {
            $busqueda = $request->busqueda;
            $query->where('id', $busqueda)
                ->orWhereHas('usuario', fn($q) => $q->where('name', 'like', "%$busqueda%"))
                ->orWhereDate('fecha_pedido', $busqueda);
        }

        $pedidos = $query->latest('fecha_pedido')->paginate(10);
        return view('admin.index', compact('pedidos'));
    }

    public function show($id)
    {
        $pedido = Pedido::with(['usuario', 'productos'])->findOrFail($id);
        return view('admin.show', compact('pedido'));
    }

    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->estado = $request->input('estado');
        $pedido->save();

        return $request->ajax()
            ? response()->json(['success' => true])
            : redirect()->back()->with('success', 'Estado actualizado correctamente.');
    }
}
