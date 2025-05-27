<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            CategoriasSeeder::class,
            ProductosSeeder::class,
            PedidosSeeder::class,
            PedidoProductoSeeder::class,
            ReviewsSeeder::class,
        ]);
    }
}
