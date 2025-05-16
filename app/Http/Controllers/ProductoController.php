<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function show(Producto $producto)
    {
        // Cargamos también las reviews y el usuario que escribió cada una
        $producto->load(['reviews.usuario']);

        return view('productos.show', compact('producto'));
    }
}
