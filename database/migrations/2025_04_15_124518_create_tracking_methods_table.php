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
        Schema::create('tracking_methods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->enum('type', ['unique_link', 'referral_code', 'qr_code', 'phone_call', 'social_media', 'visit_verification']);
            $table->string('tracking_code')->unique();
            $table->string('tracking_url')->nullable();
            $table->string('qr_code_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('verification_instructions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_methods');
    }
}; 