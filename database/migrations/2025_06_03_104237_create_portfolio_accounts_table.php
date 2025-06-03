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
        Schema::create('portfolio_accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->constrained()->cascadeOnDelete();
            $table->text('about')->nullable();

            $table->string('theme')->default('default');
            $table->string('slug')->unique(); // owena.com/@ernest

            $table->string('x_handle')->nullable();
            $table->string('github_handle')->nullable();
            $table->string('linkedin_handle')->nullable();
            $table->string('website')->nullable();

            $table->string('cta_text')->default('Contact Me');
            $table->string('location')->nullable();

            $table->enum('type', ['basic', 'standard', 'premium'])->default('basic');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_accounts');
    }
};
