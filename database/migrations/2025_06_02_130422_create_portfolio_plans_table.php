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
        Schema::create('portfolio_plans', function (Blueprint $table) {
            $table->id();
            $table->enum('name', ['basic', 'standard', 'premium'])->default('basic');
            $table->decimal('price', 10, 2)->default(0.00); // monthly price
            $table->integer('max_projects')->default(2);
            $table->boolean('allow_resume_upload')->default(false);
            $table->boolean('allow_articles')->default(false);
            $table->boolean('allow_work_experience')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_plans');
    }
};
