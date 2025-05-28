<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function create()
    {
        if (!Auth::check() || Auth::user()->rol !== 1) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return view('categorias.create');
    }

    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // validar imagen subida
        ]);

        $categoria = Categoria::findOrFail($id);

        // Actualizar campos excepto imagen (la manejamos aparte)
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;

        if ($request->hasFile('imagen')) {
            // Borrar imagen anterior si existe
            if ($categoria->imagen && file_exists(public_path($categoria->imagen))) {
                unlink(public_path($categoria->imagen));
            }

            $imagen = $request->file('imagen');
            $nombreArchivo = time() . '_' . $imagen->getClientOriginalName();
            $imagen->move(public_path('categorias'), $nombreArchivo);

            $categoria->imagen = $nombreArchivo;
        }

        $categoria->save();

        return redirect()->route('shop')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreArchivo = time() . '_' . $imagen->getClientOriginalName();
            $imagen->move(public_path('categorias'), $nombreArchivo);
            $categoria->imagen = $nombreArchivo;
        }

        $categoria->save();

        return redirect()->route('shop')
            ->with('success', 'Categoría creada correctamente.');
    }

    public function destroy(Categoria $categoria)
    {
        if (!auth()->check() || auth()->user()->rol !== 1) {
            abort(403, 'No tienes permiso para eliminar categorías.');
        }

        if ($categoria->imagen && file_exists(public_path('categorias/' . $categoria->imagen))) {
            unlink(public_path('categorias/' . $categoria->imagen));
        }

        $categoria->delete();

        return redirect()->route('shop')->with('success', 'Categoría eliminada correctamente.');
    }
}
