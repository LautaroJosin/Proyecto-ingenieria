<?php

namespace Database\Seeders;

use App\Models\LostDog;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LostDogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LostDog::factory(100)->create();
    }
}
