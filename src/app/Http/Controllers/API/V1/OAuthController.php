<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    public function telegram()
    {
        return Socialite::driver('telegram')->redirect();
    }

    public function telegramRedirect()
    {
        $telegramUser = Socialite::driver('telegram')->stateless()->user();

        $user = User::query()->where('provider_id', $telegramUser->id)->first();

        if (!$user) {
            $user = User::query()->updateOrCreate([
                'name' => $telegramUser->name,
                'email' => $telegramUser->email ?? $telegramUser->id . '@telegram.com',
                'provider_id' => $telegramUser->id,
                'password' => Hash::make(Str::random(24)),
            ]);
            auth()->attempt([
                'email' => $user->email,
                'password' => $user->password
            ]);

            $accessToken = $user->createToken('Personal Access Token');
            $token = $accessToken->plainTextToken;

            return response()->json([
                'message' => 'User has been successfully created',
                'accessToken' => $token
            ]);
        }
    }
}
