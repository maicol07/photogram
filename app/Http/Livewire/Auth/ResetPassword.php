<?php

namespace App\Http\Livewire\Auth;

use App\Http\Livewire\AuthPage;
use Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;
use Str;

class ResetPassword extends AuthPage
{
    public string $token;
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public $rules = [
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8',
        'password_confirmation' => 'required|same:password',
    ];

    public function page(): View
    {
        return view('livewire.auth.reset-password');
    }

    public function mount(string $token): void
    {
        $this->token = $token;
    }

    public function resetPassword(): void
    {
        $this->validate();

        Password::reset(
            [
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'token' => $this->token,
            ],
            static function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
        $this->redirectRoute('login');
    }

    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName, attributes: [
            "password" => __("Password"),
            "email" => __("Email"),
            "password_confirmation" => __("Repeated Password"),
        ]);
        if ($propertyName === 'password') {
            $this->validateOnly(
                "password_confirmation",
                attributes: [
                    "password" => __("Password"),
                    "email" => __("Email"),
                    "password_confirmation" => __("Repeated Password"),
                ]
            );
        }
        if ($propertyName === 'password_confirmation') {
            $this->validateOnly(
                "password",
                attributes: [
                    "password" => __("Password"),
                    "email" => __("Email"),
                    "password_confirmation" => __("Repeated Password"),
                ]
            );
        }
    }

    public function goToSignup(): void
    {
        $this->redirectRoute('signup');
    }
}
