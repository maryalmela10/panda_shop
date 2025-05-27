<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    public function run()
    {
        DB::table('categorias')->insert([
            [
                'nombre' => 'Harinas',
                'descripcion' => 'Harinas artesanales, integrales y de repostería.',
                'imagen' => 'categ_harinas.jpg',
            ],
            [
                'nombre' => 'Chocolates y Coberturas',
                'descripcion' => 'Coberturas de chocolate blanco, negro y con leche.',
                'imagen' => 'categ_chocolates.jpg',
            ],
            [
                'nombre' => 'Colorantes y Esencias',
                'descripcion' => 'Colores y aromas para repostería natural y sintética.',
                'imagen' => 'categ_colorantes.jpg',
            ],
            [
                'nombre' => 'Frutos secos',
                'descripcion' => 'Almendras, nueces, pistachos, avellanas y más.',
                'imagen' => 'categ_frutos_secos.jpg',
            ],
            [
                'nombre' => 'Decoraciones y toppings',
                'descripcion' => 'Perlitas, confites, sprinkles y decoraciones comestibles.',
                'imagen' => 'categ_toppings.jpg',
            ],
            [
                'nombre' => 'Fermentos y polvos',
                'descripcion' => 'Levaduras, polvos para hornear y estabilizantes.',
                'imagen' => 'categ_fermentos.jpg',
            ],
            [
                'nombre' => 'Preparados para postres',
                'descripcion' => 'Mezclas listas para hacer tortitas, crepes, flanes, natillas y más.',
                'imagen' => 'categ_preparados.jpg',
            ],
        ]);
    }
}
