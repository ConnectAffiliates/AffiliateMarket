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
        Schema::create('sales', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('campaign_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->uuid('referral_id')->nullable();
            $table->foreign('referral_id')->references('id')->on('referrals')->onDelete('set null');
            $table->uuid('affiliate_id');
            $table->foreign('affiliate_id')->references('id')->on('users')->onDelete('cascade');
            $table->uuid('advertiser_id');
            $table->foreign('advertiser_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->decimal('amount', 12, 2);
            $table->decimal('commission', 10, 2)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'flagged'])->default('pending');
            $table->string('order_id')->nullable()->unique();
            $table->ipAddress('ip_address')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
