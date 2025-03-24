<?php

use App\Http\Controllers\MentorProfile\CourseController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('mentor')->group(function () {
        Route::apiResource('courses', CourseController::class);
    });
});
