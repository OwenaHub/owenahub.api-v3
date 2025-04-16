<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    protected $url;

    public function store()
    {
        $this->url = env('FRONTEND_URL');

        try {
            $google_user = Socialite::driver('google')->user();

            $user = User::firstOrCreate([
                'email' => $google_user->getEmail(),
            ], [
                'name' => $google_user->getName(),
                'email' => $google_user->getEmail(),
                'password' =>  Hash::make(request(Str::random(8)))
            ]);

            // event(new Registered($user));

            Auth::login($user);

            return redirect("$this->url/dashboard/?logged_in=true"); // your React URL
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect("$this->url?error=authentication_failed"); // Handle error
        }
    }
}
