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
        Schema::create('user_lessons', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id')->constrained(table: 'users', column: 'id')->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained(table: 'lessons', column: 'id')->cascadeOnDelete();
            $table->foreignId('course_enrollment_id')->constrained(table: 'course_enrollments', column: 'id')->cascadeOnDelete();
            $table->string('completed')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_lessons');
    }
};
