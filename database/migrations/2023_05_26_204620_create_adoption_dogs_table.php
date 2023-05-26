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
        Schema::create('adoption_dogs', function (Blueprint $table) {
            $table->id();
            $table->string('race');
            $table->string('description');
            $table->enum('gender', ['S','M','B']);
            $table->date('date_of_birth');
            $table->unsignedBigInteger('user_id');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoption_dogs');
    }
};
