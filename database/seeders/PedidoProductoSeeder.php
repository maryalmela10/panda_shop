<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedidoProductoSeeder extends Seeder
{
    public function run()
    {
        DB::table('pedido_producto')->insert([
            [
                'pedido_id' => 1,
                'producto_id' => 1, // Harina de trigo
                'cantidad' => 3,
                'precio_producto' => 2.50,
            ],
            [
                'pedido_id' => 1,
                'producto_id' => 3, // Chocolate blanco Nestlé
                'cantidad' => 5,
                'precio_producto' => 4.60,
            ],
            [
                'pedido_id' => 1,
                'producto_id' => 10, // Perlas plateadas
                'cantidad' => 2,
                'precio_producto' => 2.60,
            ],
        ]);
    }
}
