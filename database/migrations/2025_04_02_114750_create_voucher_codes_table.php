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
        Schema::create('voucher_codes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mentor_profile_id')
                ->constrained('mentor_profiles')->cascadeOnDelete();

            $table->string('issued_to')->nullable(); // user email address

            $table->string('code');
            $table->decimal('price', 8, 2)->nullable();
            $table->enum('status', ['unused', 'expired', 'redeemed'])->default('unused');
            $table->date('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_codes');
    }
};
