<?php

use App\Http\Controllers\MentorProfile\CourseController;
use App\Http\Controllers\MentorProfile\ModuleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('mentor')->group(function () {
        
        Route::apiResource('courses', CourseController::class);

        Route::prefix('courses')->group(function () {
            Route::post('{course}/modules', [ModuleController::class, 'store']);
            Route::put('{course}/modules/{module}', [ModuleController::class, 'update']);
            Route::delete('modules/{module}', [ModuleController::class, 'destroy']);
        });
    });
});
