<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class PedidoProductoSeeder extends Seeder
{
    public function run()
    {
        $pedido = Pedido::first(); // obtener el primer pedido real
        $producto1 = Producto::find(1);
        $producto2 = Producto::find(3);
        $producto3 = Producto::find(10);

         if (!$pedido || !$producto1 || !$producto2 || !$producto3) {
            dump("Faltan datos: pedido o productos no existen");
            return;
        }

        DB::table('pedido_producto')->insert([
            [
                'pedido_id' => $pedido->id,
                'producto_id' => 1, // Harina de trigo
                'cantidad' => 3,
                'precio_producto' => 2.50,
            ],
            [
                'pedido_id' => $pedido->id,
                'producto_id' => 3, // Chocolate blanco Nestlé
                'cantidad' => 5,
                'precio_producto' => 4.60,
            ],
            [
                'pedido_id' => $pedido->id,
                'producto_id' => 10, // Perlas plateadas
                'cantidad' => 2,
                'precio_producto' => 2.60,
            ],
        ]);
    }
}
