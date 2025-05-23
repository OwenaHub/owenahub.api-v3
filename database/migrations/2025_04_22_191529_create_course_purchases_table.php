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
        Schema::create('course_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->uuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->ulid('course_id')->constrained('courses')->cascadeOnDelete();
            $table->decimal('price', 8, 2);
            $table->string('payment_method', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_purchases');
    }
};
