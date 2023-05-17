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
        Schema::create('treatments', function(Blueprint $table) {
            $table->id();
            $table->date('date_of_appointment');
            $table->string('reason');
            $table->double('weight');
            $table->string('vaccine')->nullable();
            $table->integer('dewormer')->nullable();
            $table->unsignedBigInteger('dog_id')->nullable();

            $table->foreign('dog_id')->references('id')->on('dogs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatments');
    }
};
