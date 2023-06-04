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
        Schema::create('caregivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['W', 'C', 'B']); // W = walker, C = caregiver, B = both
            $table->string('email')->unique();
            $table->boolean('is_active')->default(true);
 
            $table->unsignedBigInteger('park_id')->nullable();
            $table->foreign('park_id')->references('id')->on('parks')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caregivers');
    }
};
