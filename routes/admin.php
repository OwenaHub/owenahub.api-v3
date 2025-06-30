<?php

use App\Http\Controllers\Admin\ManageUserOwenaplusSubscriptionController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('users', function () {
            $users = User::latest()->get();

            return UserResource::collection($users);
        });

        Route::post('users/{user}/owenaplus-subscription', ManageUserOwenaplusSubscriptionController::class);
    });
});
