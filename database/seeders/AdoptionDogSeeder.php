<?php

namespace Database\Seeders;

use App\Models\AdoptionDog;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdoptionDogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdoptionDog::factory(50)->create();
    }
}
