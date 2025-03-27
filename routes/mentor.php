<?php

use App\Http\Controllers\MentorProfile\CourseController;
use App\Http\Controllers\MentorProfile\LessonController;
use App\Http\Controllers\MentorProfile\ModuleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('mentor')->group(function () {

        Route::apiResource('courses', CourseController::class);

        Route::prefix('courses')->group(function () {
            Route::post('{course}/modules', [ModuleController::class, 'store']); // Create module
            Route::get('{course}/modules/{module}', [ModuleController::class, 'show']); // Get module
            Route::put('{course}/modules/{module}', [ModuleController::class, 'update']); // Update module
            Route::delete('modules/{module}', [ModuleController::class, 'destroy']); // Delete module

            Route::post('{course}/modules/{module}', [LessonController::class, 'store']); // Create lesson
            Route::post('modules/{module}', [LessonController::class, 'show']); // Get lesson
            Route::put('modules/{module}', [LessonController::class, 'update']); // Update lesson
            Route::delete('modules/{module}', [LessonController::class, 'destroy']); // Delete lesson
        });
    });
});
