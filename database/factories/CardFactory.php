<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'card_type' => fake()->randomElement(['C','D']),
            'cardholder' => fake()->numberBetween($min = 40000000, $max = 50000000),
            'card_number' => fake()->randomNumber($nmMaxDecimals = 16 , $strict = true),
            'cvv' => fake()->randomNumber($nmMaxDecimals = 3 , $strict = true),
            'expiration_date' => fake()->dateTimeBetween($startDate = '+ 2 years', $endDate = '+ 4 years'),
        ];
    }
}
