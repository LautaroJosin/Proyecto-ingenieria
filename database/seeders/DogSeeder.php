<?php

namespace Database\Seeders;

use App\Models\Dog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

require_once 'vendor/autoload.php';

class DogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Dog::create([
            'id' => '666',
            'name' => 'Pepe',
            'gender' => 'M',
            'race' => 'Pug',
            'date_of_birth' => fake()->date('Y-m-d', 'now'),
            'description' => 'Es marron',
            'is_on_tinder' => 0,
            'photo' => fake()->imageUrl(1080, 720, 'dog'),
            'user_id' => 4,
        ]);
    }
}
