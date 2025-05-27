<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categoria>
 */
class CategoriaFactory extends Factory
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
            'nombre' => $this->faker->unique()->word(),
            'descripcion' => $this->faker->sentence(10),
            'imagen' => 'productos/' . $imagePath,
        ];
    }
}
