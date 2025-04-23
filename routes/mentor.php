<?php

use App\Http\Controllers\MentorProfile\CourseController;
use App\Http\Controllers\MentorProfile\LessonController;
use App\Http\Controllers\MentorProfile\ModuleController;
use App\Http\Controllers\MentorProfile\TaskController;
use App\Http\Controllers\MentorProfile\VoucherCodeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('mentor')->group(function () {

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
    Route::prefix('tasks')->group(function () {
        Route::post('lessons/{lesson}', [TaskController::class, 'store']);
        Route::delete('{task}', [TaskController::class, 'destroy']);
        Route::patch('{task}', [TaskController::class, 'update']);
        Route::get('{task}', [TaskController::class, 'show']);
    });

    // Voucher Code Routes
    Route::apiResource('voucher-codes', VoucherCodeController::class)
        ->only(['index', 'store', 'destroy']);
});
