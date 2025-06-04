<?php

use App\Http\Controllers\PortfolioAccount\CreatePortfolioAccountController;
use App\Http\Controllers\User\CourseEnrollmentController;
use App\Http\Controllers\User\GetCoursesController;
use App\Http\Controllers\User\GetLessonController;
use App\Http\Controllers\User\TaskSubmissionController;
 use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::get('courses', [GetCoursesController::class, 'index']);
    Route::get('courses/{course}', [GetCoursesController::class, 'show']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('enrollment/courses', [CourseEnrollmentController::class, 'index']);
        Route::post('enrollment/courses/{course}', [CourseEnrollmentController::class, 'store']);
        Route::get('enrollment/courses/{course}', [CourseEnrollmentController::class, 'show']);

        Route::get('enrollment/courses/{course}/modules/{module}/lessons/{lesson}', [GetLessonController::class, 'index']);
        Route::post('enrollment/user-course/{lesson}', [GetLessonController::class, 'store']);

        Route::prefix('tasks')->group(function () {
            Route::post('{task}/task-submission', [TaskSubmissionController::class, 'store']);
            Route::patch('task-submission/{taskSubmission}', [TaskSubmissionController::class, 'update']);
            Route::get('task-submission/{taskSubmission}', [TaskSubmissionController::class, 'show']);
        });

        Route::prefix('accounts/portfolio')->group(function () {
            Route::post('/', [CreatePortfolioAccountController::class, 'store']);
        });
    });
});
