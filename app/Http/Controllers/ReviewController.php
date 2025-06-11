<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
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

    public function responder(Request $request, Producto $producto, Review $review)
    {
        // Opcional: Validar que el usuario sea admin
        if (auth()->user()->rol != 1) {
            abort(403, 'No autorizado');
        }

        // Validar datos
        $request->validate([
            'respuesta' => 'required|string|max:1000',
        ]);

        // Guardar la respuesta
        $review->respuesta = $request->input('respuesta');
        $review->save();

        return redirect()->back()->with('success', 'Respuesta enviada correctamente.');
    }
}
