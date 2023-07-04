<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /* Hay creadas 4 tarjetas : 

                - 2 validas

                - 1 sin saldo

                - 1 que debe fallar al intentar conectar con el servidor
        */

        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->enum('card_type' , ['C','D']);
            $table->string('cardholder');
            $table->bigInteger('card_number')->unsigned()->unique();
            $table->integer('cvv');
            $table->date('expiration_date');
            $table->double('balance', 10, 2); // precision (total digits) , scale (decimal digits)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
