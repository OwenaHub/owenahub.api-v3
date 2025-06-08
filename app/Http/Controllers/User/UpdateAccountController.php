<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\UpdateAccountRequest;
use Illuminate\Support\Facades\Auth;

class UpdateAccountController extends Controller
{
    public function update(UpdateAccountRequest $request)
    {
        $user = Auth::user();

        $data = $request->validated();

        try {
            if ($request->hasFile('profile_picture')) {
                $data['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
            }

            $user->update($data);

            $user->notification()->create([
                'source' => 'account',
                'content' => "Your account has been updated successfully."
            ]);

            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
