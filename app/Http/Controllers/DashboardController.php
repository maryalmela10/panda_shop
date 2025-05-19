<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class DashboardController extends Controller {

    public function index(Request $request)
    {
        return view('dashboard');
    }
}
