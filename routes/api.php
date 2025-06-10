<?php

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });
});

require __DIR__ . '/auth.php';
require __DIR__ . '/user.php';
require __DIR__ . '/mentor.php';
require __DIR__ . '/admin.php';
