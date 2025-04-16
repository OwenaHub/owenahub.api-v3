<?php

use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\User\UpdateAccountController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });

    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::patch('/account', [UpdateAccountController::class, 'update']);
});

require __DIR__ . '/auth.php';
require __DIR__ . '/mentor.php';
require __DIR__ . '/user.php';
