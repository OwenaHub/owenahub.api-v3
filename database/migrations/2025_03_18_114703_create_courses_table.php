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
        Schema::create('courses', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignId('mentor_profile_id')->constrained('mentor_profiles')->cascadeOnDelete();

            $table->string('title');
            $table->string('description');
            $table->string('thumbnail');
            $table->decimal('price', 8, 2)->default(0.00);
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->default('intermediate');
            $table->enum('status', ['draft', 'published'])->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
