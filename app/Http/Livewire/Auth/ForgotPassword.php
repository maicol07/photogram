<?php

namespace App\Http\Livewire\Auth;

use App\Http\Livewire\AuthPage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;

class ForgotPassword extends AuthPage
{
    public string $email = '';

    public function page(): View
    {
        return view('livewire.auth.forgot-password');
    }

    public function sendReset(): void
    {
        $this->validate(
            ['email' => 'required|email']
        );

        Password::sendResetLink(['email' => $this->email]);
    }

    public function goToSignup(): void
    {
        $this->redirectRoute('signup');
    }
}
