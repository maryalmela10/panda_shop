<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReviewsSeeder extends Seeder
{
    public function run()
    {
        DB::table('reviews')->insert([
            [
                'usuario_id' => 2,
                'producto_id' => 1, // Harina de trigo
                'comentario' => 'Harina excelente para mis bizcochos, muy fina.',
                'estrellas' => 5,
                'fecha' => Carbon::now()->subDays(3),
            ],
            [
                'usuario_id' => 2,
                'producto_id' => 3, // Chocolate blanco
                'comentario' => 'Se funde muy bien, ideal para coberturas.',
                'estrellas' => 4,
                'fecha' => Carbon::now()->subDays(2),
            ],
            [
                'usuario_id' => 2,
                'producto_id' => 6, // Esencia de vainilla
                'comentario' => 'Huele genial, pero me gustaría que fuera más concentrada.',
                'estrellas' => 3,
                'fecha' => Carbon::now()->subDays(1),
            ],
        ]);
    }
}
