<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdenProductoSeeder extends Seeder
{
    public function run()
    {
        DB::table('orden_producto')->insert([
            [
                'orden_id' => 1,
                'producto_id' => 1, // Harina de trigo
                'cantidad' => 3,
                'precio' => 2.50,
            ],
            [
                'orden_id' => 1,
                'producto_id' => 3, // Chocolate blanco Nestlé
                'cantidad' => 5,
                'precio' => 4.60,
            ],
            [
                'orden_id' => 1,
                'producto_id' => 10, // Perlas plateadas
                'cantidad' => 2,
                'precio' => 2.60,
            ],
        ]);
    }
}
