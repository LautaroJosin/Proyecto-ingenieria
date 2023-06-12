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
            $table->enum('gender', ['M', 'H'] );
            $table->string('race');
            $table->string('description');
			$table->enum( 'size', [ 'P' , 'M' , 'G' ] );
            $table->date('date_of_birth');
            $table->unsignedBigInteger('user_id')->nullable();
			$table->string('temp_name');
			$table->enum('state', ['S' , 'A']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->unique(['user_id', 'temp_name'])->id();
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
