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
        Schema::create('user_portfolio_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('portfolio_plan_id')->constrained()->cascadeOnDelete();
            $table->enum('is_active', ['active', 'expired', 'cancelled'])->default('active');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_portfolio_subscriptions');
    }
};
