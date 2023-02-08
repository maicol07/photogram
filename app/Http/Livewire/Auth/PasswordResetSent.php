<?php

namespace App\Http\Livewire\Auth;

use App\Http\Livewire\Page;
use Illuminate\Contracts\View\View;

class PasswordResetSent extends Page
{
    public function page(): View
    {
        return view('livewire.auth.password-reset-sent');
    }

    public function resendEmail(): void
    {
        $this->redirectRoute("password.reset");
    }
}
