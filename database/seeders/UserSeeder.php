<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'dni' => '0',
            'surname' => 'admin',
            'phone' => '0',
            'name' => 'admin',
            'email' => 'admin@admin',
            'email_verified_at' => now(),
            'password'=> Hash::make('admin'),
            'password_to_show' => 'admin',
            'remember_token' => Str::random(10),
        ])->assignRole('admin');

        User::create([
            'dni' => '1',
            'surname' => 'user',
            'phone' => '1',
            'name' => 'user',
            'email' => 'user@user',
            'email_verified_at' => now(),
            'password'=> Hash::make('user'),
            'password_to_show' => 'user',
            'remember_token' => Str::random(10),
        ])->assignRole('user');

        User::create([
            'dni' => '40221319',
            'surname' => 'Castro',
            'phone' => '19399584',
            'name' => 'Lautaro',
            'email' => 'lautaro.castro.est@gmail.com',
            'email_verified_at' => now(),
            'password'=> Hash::make('12345678'),
            'password_to_show' => '12345678',
            'remember_token' => Str::random(10),
        ])->assignRole('user');


        User::create([
            'dni' => '43505906',
            'surname' => 'Josin',
            'phone' => '19399584',
            'name' => 'Lautaro',
            'email' => 'lauj32@gmail.com',
            'email_verified_at' => now(),
            'password'=> Hash::make('666'),
            'password_to_show' => '666',
            'remember_token' => Str::random(10),
        ])->assignRole('user');
    }
}