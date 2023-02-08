<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class OAuth extends Controller
{
    public function authGoogle(): RedirectResponse
    {
        $googleUser = Socialite::driver('google')->user();

        Storage::disk('public')->put('profile/images/google' . $googleUser->getId(), file_get_contents($googleUser->getAvatar()));
        $username = str_replace(' ', '_', $googleUser->getNickname());
        if (User::find($username, 'username')->exists()) {
            $username .= $googleUser->getId();
        }

        try {
            $user = User::updateOrCreate([
                'google_id' => $googleUser->id,
            ], [
                'name' => $googleUser->user['given_name'],
                'surname' => $googleUser->user['family_name'],
                'email' => $googleUser->getEmail(),
                'username' => $username,
                'profileImage' => 'google' . $googleUser->getId(),
                'email_verified_at' => Carbon::now(),
                'google_id' => $googleUser->getId(),
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);

            Auth::login($user);

            return redirect()->route('inside.home');
        } catch (QueryException $e) {
            return redirect()->route('login', ['error_auth_google' => $e->errorInfo[1]]);
        }
    }
}
