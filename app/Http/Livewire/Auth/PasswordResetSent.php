<?php

namespace App\Http\Livewire\Auth;

use App\Http\Livewire\AuthPage;
use Illuminate\Contracts\View\View;

class PasswordResetSent extends AuthPage
{
    public function page(): View
    {
        return view('livewire.auth.password-reset-sent');
    }

    public function resendEmail(): void
    {
        $this->redirectRoute("password.reset");
    }

    public function getTitle(): string
    {
        return __('Check your Emails!');
    }
}
