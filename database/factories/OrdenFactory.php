<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orden>
 */
class OrdenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'usuario_id' => $this->faker->numberBetween(2, 6),
            'metodo_pago' => $this->faker->randomElement(['tarjeta', 'paypal', 'transferencia']),
            'coste_envio' => $this->faker->randomFloat(2, 0, 15),
            'direccion_envio' => $this->faker->address(),
            'fecha_pedido' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
