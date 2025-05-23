<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Categoria::all();
        $selectedCategory = $request->input('categoria_id');
        $sortOption = $request->input('sort');

        $query = Producto::query();

        if ($selectedCategory) {
            $query->where('categoria_id', $selectedCategory);
        }

        // Ordenamiento
        switch ($sortOption) {
            case 'price_asc':
                $query->orderBy('precio', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('precio', 'desc');
                break;
            case 'bestsellers':
                $query->orderBy('num_ventas', 'desc'); 
                break;
            default:
                $query->latest(); // Orden por defecto (por fecha de creación)
                break;
        }

        $products = $query->paginate(9)->appends($request->query());

        return view('customerViews.shop', compact('products', 'categories', 'selectedCategory'));
    }
    
}
