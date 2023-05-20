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
        Schema::create('appointment', function (Blueprint $table) {
            $table->id();
            $table->enum('state', ['P', 'C', 'A']);
            $table->date('date');
            //Salvo que se me ocurra algo mejor, acá va a ir un atributo derivado "precioConDescuento en el futuro
            $table->unsignedBigInteger('reason_id')->nullable();
            $table->unsignedBigInteger('dog_id')->nullable();

            $table->foreign('reason_id')->references('id')->on('reasons')->onDelete('set null');
            $table->foreign('dog_id')->references('id')->on('dogs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment');
    }
};
