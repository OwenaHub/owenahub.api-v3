<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateAccountController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'sometimes|nullable|string|max:255',
            'username' => 'sometimes|nullable|string|max:50|unique:users,username,' . $user->id,
            'email' => 'sometimes|nullable|email|unique:users,email,' . $user->id,
            'profile_picture' => 'sometimes|nullable|url',
            'title' => 'sometimes|nullable|string|max:255',
            'biography' => 'sometimes|nullable|string',
            'account_type' => 'sometimes|nullable|in:user,mentor,admin',
        ]);

        $user->update($validatedData);

        $user->notification()->create([
            'source' => 'account',
            'content' => "Your account has been updated successfully."
        ]);

        return response()->noContent();
    }
}
