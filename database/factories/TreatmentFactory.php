<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Treatment>
 */
class TreatmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date_of_appointment' => $this->faker->date('Y-m-d', 'now'),
            'reason' => $this->faker->randomElement(['General', 'Vacuna', 'Desparasitacion']),
            'weight' => $this->faker->randomNumber(2, false),
            'vaccine' => $this->faker->randomElement(['Antirrabica', 'Enfermedades']),
            'dewormer' => $this->faker->randomNumber(1, true),
        ];
    }
}
