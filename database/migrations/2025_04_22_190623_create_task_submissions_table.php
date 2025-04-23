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
        Schema::create('task_submissions', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id')->constrained(table: 'users', column: 'id')->cascadeOnDelete();
            $table->foreignId('task_id')->constrained(table: 'tasks', column: 'id')->cascadeOnDelete();
            $table->text('content')->nullable();
            $table->text('feedback')->nullable();
            $table->string('file_url')->nullable();
            $table->enum('status', ['pending', 'failed', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_task_submissions');
    }
};
