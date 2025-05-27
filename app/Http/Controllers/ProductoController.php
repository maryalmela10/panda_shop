<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;
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

    public function create()
    {
        if (!Auth::check() || Auth::user()->rol !== 1) {
            abort(403);
        }

        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    public function edit($id)
    {
        // Busca el producto por ID
        $producto = Producto::findOrFail($id);

        // Obtén todas las categorías para el select
        $categorias = Categoria::all();

        // Retorna la vista de edición, pasando el producto y las categorías
        return view('productos.edit', compact('producto', 'categorias'));
    }


public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'disponible' => 'required|boolean',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'fecha_reposicion' => 'nullable|date',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->fill($request->except('imagen'));

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($producto->imagen_url && file_exists(public_path($producto->imagen_url))) {
                unlink(public_path($producto->imagen_url));
            }

            $imagen = $request->file('imagen');
            $nombreArchivo = time() . '_' . $imagen->getClientOriginalName();
            $imagen->move(public_path('productos'), $nombreArchivo);
            $producto->imagen_url = 'productos/' . $nombreArchivo;
        }

        $producto->save();

        return redirect()->route('shop')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'disponible' => 'required|boolean',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'fecha_reposicion' => 'nullable|date',
        ]);

        $producto = new Producto();
        $producto->fill($request->except('imagen'));

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreArchivo = time() . '_' . $imagen->getClientOriginalName();
            $imagen->move(public_path('productos'), $nombreArchivo);
            $producto->imagen_url = 'productos/' . $nombreArchivo;
        }

        $producto->save();

        return redirect()->route('shop')
            ->with('success', 'Producto creado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        if (!auth()->check() || auth()->user()->rol !== 1) {
            abort(403, 'No tienes permiso para eliminar productos.');
        }

        // Eliminar imagen física si existe
        if ($producto->imagen_url && file_exists(public_path($producto->imagen_url))) {
            unlink(public_path($producto->imagen_url));
        }

        $producto->delete();

        return redirect()->route('shop')->with('success', 'Producto eliminado correctamente.');
    }
}
