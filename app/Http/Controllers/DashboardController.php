<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class DashboardController extends Controller {

    public function index(Request $request)
    {
        $categories = Categoria::all();
        $selectedCategory = $request->input('categoria_id');

        $products = Producto::when($selectedCategory, function ($query, $categoriaId) {
            return $query->where('categoria_id', $categoriaId);
        })->get();

        return view('dashboard', compact('products', 'categories', 'selectedCategory'));
    }
}
