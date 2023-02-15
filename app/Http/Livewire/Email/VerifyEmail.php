<?php

namespace App\Http\Livewire\Email;

use App\Http\Livewire\AuthPage;
use App\Http\Livewire\Traits\MDCSnackbarFeatures;
use Illuminate\Contracts\View\View;

class VerifyEmail extends AuthPage
{
    use MDCSnackbarFeatures;

    public function mount(): void
    {
        if (request()?->user()?->hasVerifiedEmail()) {
            $this->redirectRoute('home');
        }
    }

    public function page(): View
    {
        return view('livewire.email.verify-email');
    }

    public function getTitle(): string
    {
        return __('Verify Email');
    }

    public function resendEmail(): void
    {
        request()?->user()->sendEmailVerificationNotification();
        $this->openSnackbar('resendEmail', __('An email has been sent!'));
    }
}
