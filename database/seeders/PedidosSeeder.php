<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Pedido;

class PedidosSeeder extends Seeder
{
    public function run()
    {
           $user = User::create([
                'name' => 'Cliente Review',
                'email' => 'review@cliente.com',
                'password' => bcrypt('12345678'),
                'telefono' => '000000000',
                'address' => 'Calle Opinión',
                'rol' => 0,
                'email_verified_at' => now(),
            ]);
            
        DB::table('pedidos')->insert([
            [
               'usuario_id' => $user->id,
                'metodo_pago' => 'tarjeta',
                'coste_envio' => 5.00,
                'direccion_envio' => 'Calle Ficticia 123',
                'estado' => 'confirmado',
                'total_pagado' => 50.00,
                'fecha_pedido' => Carbon::now()->subDays(2),
            ],
        ]);
    }
}
