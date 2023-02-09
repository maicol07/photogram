<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    public function authGoogle(): RedirectResponse
    {
        $googleUser = Socialite::driver('google')->user();

        Storage::disk('public')->put('profile/images/google' . $googleUser->getId(), file_get_contents($googleUser->getAvatar()));
        $username = str_replace(' ', '_', $googleUser->getNickname());
        if (User::whereUsername($username)->exists()) {
            $username .= $googleUser->getId();
        }

        try {
            $user = Auth::user();
            if ($user === null) {
                $user = User::updateOrCreate([
                    'google_id' => $googleUser->id,
                ], [
                    'name' => $googleUser->user['given_name'],
                    'surname' => $googleUser->user['family_name'],
                    'email' => $googleUser->getEmail(),
                    'username' => $username,
                    'profileImage' => 'google' . $googleUser->getId(),
                    'email_verified_at' => Carbon::now(),
                ]);

                Auth::login($user);
            }

            $user->update([
                'google_id' => $googleUser->getId(),
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);

            return redirect()->route(session()->pull('from', 'inside.home'));
        } catch (QueryException $e) {
            $message = match ($e->errorInfo[1]) {
                1062 => __('It seems your email address is already registered. You may have already an account registered in our systems. Please login with your credentials.'),
                default => 'An error has occurred: ' . $e->errorInfo[1] . ' - ' . $e->errorInfo[2],
            };
            session()->flash('message', $message);
            return redirect()->route(session()->pull('from', 'login'));
        }
    }
}
