<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Obtenemos todas las categorías
        $categories = Categoria::all();
    
        // Obtenemos el id de la categoría seleccionada desde la URL (si existe)
        $selectedCategory = $request->input('categoria_id');  
    
        // Si se pasa un categoria_id, filtramos los productos por categoría
        if ($selectedCategory) {
            // Filtramos los productos de esa categoría
            $products = Producto::where('categoria_id', $selectedCategory)->paginate(9);
        } else {
            // Si no se pasa categoria_id, mostramos todos los productos
            $products = Producto::paginate(9);
        }
    
        // Pasamos los datos a la vista
        return view('customerViews.shop', compact('products', 'categories', 'selectedCategory'));
    }
    
}
