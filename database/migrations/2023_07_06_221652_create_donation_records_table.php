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
        Schema::create('donation_records', function (Blueprint $table) {
            $table->id();

            
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('campaign_id')->nullable();

            $table->boolean('was_registered');
            $table->timestamp('donation_time',$precision = 0)->useCurrent();
            $table->date('donation_date')->useCurrent();
            $table->double('amount', 10, 2)->unsigned()->default(0.00);


            $table->unique(['campaign_id','donation_time','donation_date',])->id();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('campaign_id')->references('id')->on('donation_campaigns')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_records');
    }
};
