<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $formatted_name = ucwords(strtolower($request->name));

        $user = User::create([
            'name' => $formatted_name,
            'email' => $request->email,
            'password' => Hash::make($request->string('password')),
        ]);

        $user->notification()->create([
            'source' => 'dashboard',
            'content' => "Hi, $user->name, welcome aboard"
        ]);

        // event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}
