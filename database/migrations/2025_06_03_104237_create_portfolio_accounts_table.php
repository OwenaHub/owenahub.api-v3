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
            $table->id();
            $table->uuid('user_id')->constrained()->cascadeOnDelete();
            $table->text('about')->nullable();

            $table->string('theme')->default('default');
            $table->string('slug')->unique(); // owena.com/@ernest

            $table->string('x_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('website')->nullable();

            $table->string('location')->nullable();
            $table->json('meta')->default(json_encode(['cta' => 'Contact Me']));
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
