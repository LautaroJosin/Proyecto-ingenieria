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
        Schema::create('dogs', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', ['M', 'H']);
            $table->string('race');
            $table->string('description');
            $table->date('date_of_birth');
            $table->string('photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dogs');
    }
};
