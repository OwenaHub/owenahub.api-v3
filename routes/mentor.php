<?php

use App\Http\Controllers\MentorProfile\CourseController;
use App\Http\Controllers\MentorProfile\LessonController;
use App\Http\Controllers\MentorProfile\ModuleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('mentor')->group(function () {

        Route::apiResource('courses', CourseController::class);

        Route::prefix('courses/{course}')->group(function () {
            Route::apiResource('modules', ModuleController::class)->except(['index']);

            Route::prefix('modules/{module}')->group(function () {
                Route::apiResource('lessons', LessonController::class)->except(['index']);
            });
        });
    });
});
