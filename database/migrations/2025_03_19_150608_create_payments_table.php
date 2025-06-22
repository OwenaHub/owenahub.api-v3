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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->constrained()->cascadeOnDelete();
            $table->string('transaction_reference');
            $table->decimal('amount', 8, 2);
            $table->json('metadata')->nullable();
            $table->enum('purchase_item', ['course', 'portfolio', 'subscription'])->default('course');
            $table->enum('status', ['pending', 'successful', 'failed'])->default('pending');
            $table->enum('payment_gateway', ['flutterwave', 'paystack', 'stripe'])->default('paystack');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
