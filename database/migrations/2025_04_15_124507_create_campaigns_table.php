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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->enum('campaign_type', ['physical', 'online', 'hybrid'])->default('online');
            $table->string('target_url')->nullable();
            $table->string('physical_address')->nullable();
            $table->string('phone_number')->nullable();
            $table->json('social_media_links')->nullable();
            $table->decimal('budget', 12, 2);
            $table->decimal('cost_per_click', 10, 2);
            $table->decimal('cost_per_action', 10, 2);
            $table->decimal('commission_percentage', 5, 2)->default(0.00);
            $table->decimal('commission_fixed', 10, 2)->default(0.00);
            $table->enum('commission_type', ['percentage', 'fixed', 'hybrid'])->default('percentage');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->enum('status', ['active', 'paused', 'completed', 'cancelled'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
