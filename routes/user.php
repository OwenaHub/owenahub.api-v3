<?php

use App\Http\Controllers\User\GetCoursesController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::get('courses', [GetCoursesController::class, 'index']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('user')->group(function () {});
});
