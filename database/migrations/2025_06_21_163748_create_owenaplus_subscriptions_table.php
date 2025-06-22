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
        Schema::create('owenaplus_subscriptions', function (Blueprint $table) {
            $table->ulid()->primary();
            $table->uuid('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('owenaplus_plan_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['active', 'cancelled', 'expired'])->default('active');
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
        Schema::dropIfExists('owenaplus_subscriptions');
    }
};
