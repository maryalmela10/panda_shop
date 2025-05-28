<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Producto $producto)
    {
        return view('reviews.create', compact('producto'));
    }

    public function store(Request $request, Producto $producto)
    {
        $request->validate([
            'estrellas' => 'required|integer|min:0|max:5',
            'comentario' => 'required|string|max:1000',
        ]);

        Review::create([
            'producto_id' => $producto->id,
            'usuario_id' => auth()->id(),
            'estrellas' => $request->estrellas,
            'comentario' => $request->comentario,
        ]);

        return redirect()->route('shop.product', $producto)
        ->with('success', '¡Gracias por tu reseña!');
    }
}
