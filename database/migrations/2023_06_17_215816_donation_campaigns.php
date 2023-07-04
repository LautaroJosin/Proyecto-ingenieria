<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\DonationCampaignStatesEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donation_campaigns', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('fundraising_goal');
            $table->string('description');
            $table->string('photo');
            $table->enum('state', DonationCampaignStatesEnum::values())->default(DonationCampaignStatesEnum::ACTIVE->value);
            $table->double('current_fundraised', 10, 2)->unsigned()->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_campaigns');
    }
};
