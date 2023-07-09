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
            'temp_name' => fake()->unique()->firstName(null),
            'gender' => fake()->randomElement(['M','H']),
            'race' => fake()->randomElement(['Pug','Labrador', 'Caniche', 'Beagle', 'Mestizo', 'Boxer', 'Terrier',]),
            'date_of_birth' => $this->faker->date('Y-m-d', 'now'),
            'size' => fake()->randomElement(['P','M','G']),
            'description' => fake()->randomElement(['Es lindo','Tiene rulos','Se mueve mucho','Come mucho','Duerme mucho','Ladra mucho','Esta gordito']),
            'state' => fake()->randomElement(['S','A']),
            'user_id' => 4
        ];
    }
}
