<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'state' => fake()->randomElement(['Pendiente','Confirmado', 'Completado', 'Confirmado', 'Rechazado', 'Cancelado', 'Perdido']),
            'date' => fake()->date('Y-m-d', '01/01/2025'),
            'time' => fake()->time('H:i:s', 'now'),
            'reason_id' => numberBetween('1','5'),
        ];
    }
}
