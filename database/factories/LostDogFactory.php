<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LostDog>
 */
class LostDogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(null),
            'type' => fake()->randomElement(['L','F']),
            'found' => fake()->boolean(50),
            'reunited'=> fake()->boolean(50),
            'gender' => fake()->randomElement(['M', 'H']),
            'race' => fake()->randomElement(['Pug','Labrador', 'Caniche', 'Beagle', 'Mestizo', 'Boxer', 'Terrier',]),
            'date_of_birth' => fake()->date('Y-m-d', 'now'),
            'description' => fake()->sentence(),
            'place' => fake()->address(),
            'photo' => fake()->imageUrl(1080, 720, 'dog'),
        ];
    }
}
