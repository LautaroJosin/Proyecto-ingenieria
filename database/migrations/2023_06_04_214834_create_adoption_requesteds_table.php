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
            
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('dog_requested');


            $table->unique(['user_id', 'dog_requested'])->id();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('dog_requested')->references('id')->on('adoption_dogs');
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
