<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Card;
use Carbon\Carbon;


class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    	/* Tarjetas validas */ 

        Card::create([
        	'card_type' => 'C',
        	'cardholder' => 'Lautaro Josin',
        	'card_number' => '1111222233334444',
        	'cvv' => '123',
        	'expiration_date' => Carbon::create('2025', '01', '01'),
        	'balance' => '10000.50'
        ]);

        Card::create([
        	'card_type' => 'D',
        	'cardholder' => 'Ezequiel Reale',
        	'card_number' => '6666777788889999',
        	'cvv' => '321',
        	'expiration_date' => Carbon::create('2027', '02', '03'),
        	'balance' => '9500.50'
        ]);

        /* Tarjetas con saldo 0 */ 

       	Card::create([
        	'card_type' => 'C',
        	'cardholder' => 'Lautaro Castro',
        	'card_number' => '3333444455556666',
        	'cvv' => '567',
        	'expiration_date' => Carbon::create('2026', '07', '05'),
        	'balance' => '0'
        ]);

        /* Tarjetas que ya expiro 
		
        Card::create([
        	'card_type' => 'D',
        	'cardholder' => 'Lionel Andres Messi',
        	'card_number' => '2222333344445555',
        	'cvv' => '222',
        	'expiration_date' => Carbon::create('2000', '01', '01'),
        	'balance' => '5000'
        ]);
		
		*/

        /* Tarjetas que falla al conectarse al servidor */ 

        Card::create([
            'card_type' => 'C',
            'cardholder' => 'Juan Gonzales',
            'card_number' => '9999888877776666',
            'cvv' => '343',
            'expiration_date' => Carbon::create('2026', '02', '05'),
            'balance' => '3000.30'
        ]);
    }
}
