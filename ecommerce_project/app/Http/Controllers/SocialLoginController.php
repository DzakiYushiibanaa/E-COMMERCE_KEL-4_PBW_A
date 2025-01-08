<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SocialLoginController extends Controller
{
    // Redirect ke provider
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // Callback dari provider
    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            // Cek apakah user sudah ada di database
            $user = User::firstOrCreate(
                ['email' => $socialUser->getEmail()],
                [
                    'name' => $socialUser->getName(),
                    'password' => bcrypt(Str::random(16)), // Password default
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                ]
            );

            // Login user
            Auth::login($user);

            return redirect()->route('home.index');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Login failed! ' . $e->getMessage());
        }
    }
}
