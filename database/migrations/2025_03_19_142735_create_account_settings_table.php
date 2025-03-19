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
        Schema::create('account_settings', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id')->constrained()->cascadeOnDelete();
            $table->string('preferred_currency', 10)->default('NGN');
            $table->string('country')->nullable()->default('Nigeria');
            $table->string('language', 10)->default('en');
            $table->boolean('allow_email_notifications')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_settings');
    }
};
