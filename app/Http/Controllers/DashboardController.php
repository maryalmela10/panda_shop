<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use Illuminate\Support\Facades\Auth;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();

        // Obtener pedidos del usuario ordenados por fecha descendente, por ejemplo últimos 5
        $pedidos = Orden::where('usuario_id', $user->id)
            ->orderBy('fecha_pedido', 'desc')
            ->take(5)
            ->get();

        // Obtener la cantidad de productos en el carrito desde sesión
        $carrito = session()->get('cart', []);
        $carritoCantidad = array_sum(array_column($carrito, 'quantity'));

        return view('dashboard.home', compact('pedidos', 'carritoCantidad'));
    }
}
