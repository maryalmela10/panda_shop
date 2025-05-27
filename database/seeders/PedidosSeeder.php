<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PedidosSeeder extends Seeder
{
    public function run()
    {
        DB::table('pedidos')->insert([
            [
                'usuario_id' => 1,
                'metodo_pago' => 'tarjeta',
                'coste_envio' => 5.00,
                'direccion_envio' => 'Calle Ficticia 123',
                'fecha_pedido' => Carbon::now()->subDays(2),
            ],
        ]);
    }
}
