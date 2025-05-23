<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;
use App\Models\Categoria;


class HomeController extends Controller
{
    public function index()
    {
        // Productos más vendidos según la columna num_ventas
        $productosMasVendidos = Producto::select('id', 'nombre', 'precio', 'imagen_url')
            ->orderByDesc('num_ventas')
            ->take(5)
            ->get();

        // Categorías más vendidas calculadas sumando num_ventas de sus productos
        $categoriasMasVendidas = Categoria::select('categorias.id', 'categorias.nombre', 'categorias.descripcion', 'categorias.imagen')
            ->withSum('productos as total_vendidos', 'num_ventas')
            ->orderByDesc('total_vendidos')
            ->take(3)
            ->get();

        return view('welcome', compact('productosMasVendidos', 'categoriasMasVendidas'));
    }
}
