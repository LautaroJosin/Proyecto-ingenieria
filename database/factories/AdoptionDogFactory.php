<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdoptionDog>
 */
class AdoptionDogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'temp_name' => fake()->firstName(null),
            'gender' => fake()->randomElement(['M','H']),
            'race' => fake()-word(),
            'date_of_birth' => $this->faker->date('Y-m-d', 'now'),
            'size' => fake()->randomElement(['P','M','G']),
            'description' => fake()->sentence(),
            'state' => fake()->randomElement(['S','A']),
        ];
    }
}
