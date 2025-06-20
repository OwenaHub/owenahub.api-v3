<?php

use App\Http\Controllers\MentorProfile\CourseController;
use App\Http\Controllers\MentorProfile\LessonController;
use App\Http\Controllers\MentorProfile\ModuleController;
use App\Http\Controllers\MentorProfile\TaskController;
use App\Http\Controllers\MentorProfile\TaskSubmissionController;
use App\Http\Controllers\MentorProfile\VoucherCodeController;
use Illuminate\Support\Facades\Route;

Route::prefix('mentor')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        // Course Routes
        Route::apiResource('courses', CourseController::class);

        // Module Routes
        Route::prefix('courses/{course}')->group(function () {
            Route::apiResource('modules', ModuleController::class)->except(['index']);

            // Lesson Routes
            Route::prefix('modules/{module}')->group(function () {
                Route::apiResource('lessons', LessonController::class)->except(['index']);
            });
        });

        // Task Routes
        Route::post('lessons/{lesson}/tasks', [TaskController::class, 'store']);
        Route::get('tasks/{task}', [TaskController::class, 'show']);
        Route::patch('tasks/{task}', [TaskController::class, 'update']);
        Route::delete('tasks/{task}', [TaskController::class, 'destroy']);

        // Task Submission
        Route::get('task-submission', [TaskSubmissionController::class, 'index']);
        Route::get('task-submission/{taskSubmission}', [TaskSubmissionController::class, 'show']);
        Route::patch('task-submission/{taskSubmission}', [TaskSubmissionController::class, 'update']);

        // Voucher Code Routes
        Route::apiResource('voucher-codes', VoucherCodeController::class)
            ->only(['index', 'store', 'destroy']);
    });
});
