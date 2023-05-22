<?php

namespace Database\Seeders;

use App\Models\Reason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reason::create([
            'reason' => 'Vacuna antirrábica',
            'price' => '500',
        ]);
        Reason::create([
            'reason' => 'Vacuna contra enfermedades',
            'price' => '200',
        ]);
        Reason::create([
            'reason' => 'Consulta general',
            'price' => '300',
        ]);
        Reason::create([
            'reason' => 'Castración',
            'price' => '600',
        ]);
        Reason::create([
            'reason' => 'Desparasitación',
            'price' => '400',
        ]);
    }
}
