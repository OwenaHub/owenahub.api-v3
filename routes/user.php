<?php

use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Payment\PaystackWebhookController;
use App\Http\Controllers\Payment\VerifyPaystackPaymentController;
use App\Http\Controllers\PortfolioAccount\CreatePortfolioAccountController;
use App\Http\Controllers\User\CourseEnrollmentController;
use App\Http\Controllers\User\GetCoursesController;
use App\Http\Controllers\User\GetLessonController;
use App\Http\Controllers\User\TaskSubmissionController;
use App\Http\Controllers\User\UpdateAccountController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/notifications', [NotificationController::class, 'index']);

    Route::patch('/account', [UpdateAccountController::class, 'update']);

    Route::post('/verify-paystack', [VerifyPaystackPaymentController::class, 'index']);
    Route::post('/paystack/webhook', [PaystackWebhookController::class, 'handle']);
});

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
            Route::get('task-submission', [TaskSubmissionController::class, 'index']);
            Route::get('task-submission/{taskSubmission}', [TaskSubmissionController::class, 'show']);
            Route::post('{task}/task-submission', [TaskSubmissionController::class, 'store']);
            Route::patch('task-submission/{taskSubmission}', [TaskSubmissionController::class, 'update']);
            Route::delete('task-submission/{taskSubmission}', [TaskSubmissionController::class, 'destroy']);
        });

        Route::prefix('accounts/portfolio')->group(function () {
            Route::post('/', [CreatePortfolioAccountController::class, 'store']);
        });
    });
});
