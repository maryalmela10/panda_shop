<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function publicShow(Producto $producto)
    {
        $producto->load(['reviews.usuario', 'categoria']);

        $promedio = $producto->getReviewPromedio();
        $disponible = $producto->disponible && $producto->stock > 0;

        // Productos relacionados: misma categoría, distintos del actual
        $relacionados = Producto::where('categoria_id', $producto->categoria_id)
            ->where('id', '!=', $producto->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('customerViews.shop-single', compact('producto', 'promedio', 'disponible', 'relacionados'));
    }
}
