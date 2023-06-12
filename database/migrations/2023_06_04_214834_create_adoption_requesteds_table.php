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
        Schema::create('adoption_requesteds', function (Blueprint $table) {
            
            /* Tengo que hacer nullables tanto a user_id como user_email porque cuando registro una adopcion solicitada, la registro usando user_id + dog_requested o user_email + dog_requested, siempre uno de los campos quedará vacio */

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('dog_requested')->nullable();
            $table->string('user_email')->nullable();

            $table->unique(['user_id', 'dog_requested'])->id();
            $table->unique(['user_email', 'dog_requested'])->id();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('dog_requested')->references('id')->on('adoption_dogs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoption_requesteds');
    }
};
