<?php

use App\Http\Controllers\User\CourseEnrollmentController;
use App\Http\Controllers\User\GetCoursesController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::get('courses', [GetCoursesController::class, 'index']);
    Route::get('courses/{course}', [GetCoursesController::class, 'show']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('enrollment/courses', [CourseEnrollmentController::class, 'index']);
        Route::post('enrollment/courses/{course}', [CourseEnrollmentController::class, 'store']);
        Route::get('enrollment/courses/{course}', [CourseEnrollmentController::class, 'show']);
    });
});
