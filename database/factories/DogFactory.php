<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Dog;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dog>
 */
class DogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName(null),
            'gender' => $this->faker->randomElement(['M', 'H']),
            'race' => $this->faker->randomElement(['callejero', 'caniche', 'mestizo']),
            'date_of_birth' => $this->faker->date('Y-m-d', 'now'),
            'description' => $this->faker->colorName,
            'photo' => $this->faker->imageUrl(1080, 720, 'dog'),
            'user_id' => '2'
        ];
    }
}
