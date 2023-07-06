<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DonationCampaign;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->Name(null),
            'start_date' => $this->$faker->dateTimeBetween('next Monday', 'next Monday +7 days'),
            'end_date' => $this->$faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s').' +2 days'),
            'description' => $this->faker->sentence(),
            'photo' => $this->faker->imageUrl(1080, 720),
            'current_fundraised' => 0,
            'state' => $this->faker->randomElement(['Vigente','Finalizada']),
        ];
    }
}
