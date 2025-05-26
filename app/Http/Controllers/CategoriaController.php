<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function create()
    {
        // Verifica si el usuario tiene rol de administrador
        if (!Auth::check() || Auth::user()->rol !== 1) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return view('categorias.create');
    }

    public function edit($id)
    {
        // Busca la categoría por ID
        $categoria = Categoria::findOrFail($id);

        // Retorna la vista de edición, pasando la categoría
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|url',
        ]);

        $categoria = Categoria::findOrFail($id);

        // Actualizar los campos permitidos
        $categoria->update($request->only(['nombre', 'descripcion', 'imagen']));

        return redirect()->route('shop')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    public function store(Request $request)
    {
        // Validación y lógica para crear la categoría
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|url'
        ]);

        Categoria::create($request->all());

        return redirect()->route('shop')
            ->with('success', 'Categoría creada correctamente');
    }

    public function destroy(Categoria $categoria)
    {
        if (!auth()->check() || auth()->user()->rol !== 1) {
            abort(403, 'No tienes permiso para eliminar categorías.');
        }

        // Si quieres eliminar la imagen física también:
        if ($categoria->imagen) {
            \Storage::delete('public/categorias/' . $categoria->imagen);
        }

        $categoria->delete();

        return redirect()->route('shop')->with('success', 'Categoría eliminada correctamente.');
    }

}
