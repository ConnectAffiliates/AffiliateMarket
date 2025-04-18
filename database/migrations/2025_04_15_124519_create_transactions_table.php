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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('campaign_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->uuid('affiliate_id');
            $table->foreign('affiliate_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('set null');
            $table->unsignedBigInteger('tracking_method_id')->nullable();
            $table->foreign('tracking_method_id')->references('id')->on('tracking_methods')->onDelete('set null');
            $table->unsignedBigInteger('verification_method_id')->nullable();
            $table->foreign('verification_method_id')->references('id')->on('verification_methods')->onDelete('set null');
            $table->enum('type', ['click', 'conversion', 'visit', 'call', 'social_engagement']);
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'approved', 'rejected', 'verified', 'unverified']);
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referrer_url')->nullable();
            $table->string('proof_file_path')->nullable();
            $table->text('verification_notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->uuid('verified_by')->nullable();
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
