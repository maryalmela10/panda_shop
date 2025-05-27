<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imagePath = $this->faker->image(public_path('productos'), 640, 480, 'products', false);
        return [
            'nombre' => $this->faker->words(2, true),
            'descripcion' => $this->faker->sentence(10),
            'precio' => $this->faker->randomFloat(2, 1, 100),
            'imagen' => 'productos/' . $imagePath,
            'disponible' => $this->faker->boolean(90), // 90% probabilidad de estar disponible
            'stock' => $this->faker->numberBetween(0, 100),
            'categoria_id' => $this->faker->numberBetween(1, 5), // ajusta al número de categorías reales
            'num_ventas' => $this->faker->numberBetween(0, 500),
            'fecha_reposicion' => $this->faker->dateTimeBetween('now', '+1 month'),
        ];
    }
}
