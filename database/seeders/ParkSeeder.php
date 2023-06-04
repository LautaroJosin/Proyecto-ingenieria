<?php

namespace Database\Seeders;

use App\Models\Park;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Park::create([
            'park_name' => 'Plaza Moreno',
        ]);
        Park::create([
            'park_name' => 'Plaza San Martin',
        ]);
        Park::create([
            'park_name' => 'Plaza Malvinas Argentinas',
        ]);
        Park::create([
            'park_name' => 'Plaza Rivadavia',
        ]);
        Park::create([
            'park_name' => 'Parque Vucetich',
        ]);
        Park::create([
            'park_name' => 'Plaza Rocha',
        ]);
        Park::create([
            'park_name' => 'Plaza Italia',
        ]);
        Park::create([
            'park_name' => 'Parque Savedra',
        ]);
        Park::create([
            'park_name' => 'Plaza Matheu',
        ]);
        Park::create([
            'park_name' => 'Plaza España',
        ]);
        Park::create([
            'park_name' => 'Plaza Sarmiento',
        ]);
        Park::create([
            'park_name' => 'Parque Castelli',
        ]);
        Park::create([
            'park_name' => 'Plaza Perón',
        ]);
        Park::create([
            'park_name' => 'Plaza Yrigoyen',
        ]);
        Park::create([
            'park_name' => 'Plaza Rosas',
        ]);
        Park::create([
            'park_name' => 'Plaza Alsina',
        ]);
        Park::create([
            'park_name' => 'Plaza Olazábal',
        ]);
        Park::create([
            'park_name' => 'Plaza Belgrano',
        ]);
        Park::create([
            'park_name' => 'Plaza Güemes',
        ]);
        Park::create([
            'park_name' => 'Plaza Alberti',
        ]);
        Park::create([
            'park_name' => 'Plaza 19 de Noviembre',
        ]);
        Park::create([
            'park_name' => 'Plaza Azcuénaga',
        ]);
        Park::create([
            'park_name' => 'Plaza Paso',
        ]);
    }
}
