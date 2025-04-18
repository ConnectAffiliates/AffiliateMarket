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
        Schema::create('verification_methods', function (Blueprint $table) {
            $table->id();
            $table->uuid('campaign_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->enum('type', ['online_purchase', 'physical_visit', 'phone_call', 'social_media_engagement', 'manual_verification']);
            $table->json('verification_criteria')->nullable();
            $table->boolean('requires_proof')->default(false);
            $table->text('proof_instructions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_methods');
    }
}; 