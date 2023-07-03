<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\AppointmentStatesEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->enum('state', AppointmentStatesEnum::values());
            $table->date('date');
            $table->time('time');

            $table->double('priceWithDiscount', 10,2)->unisgned()->default(0.00);

            $table->double('credits_to_show', 10,2)->unisgned()->default(0.00); /*Almacena los creditos aplicados al precio del turno*/

            $table->boolean('discount_applied')->default(false);

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
        Schema::dropIfExists('appointments');
    }
};
