<?php

namespace App\Http\Livewire\Email;

use App\Http\Livewire\Page;
use Illuminate\Contracts\View\View;

class VerifyEmail extends Page
{
    public function page(): View
    {
        return view('livewire.email.verify-email');
    }

    public function resendEmail(): void
    {
        request()->user()->sendEmailVerificationNotification();
        $this->openSnackbar('resendEmail', __('An email has been sent!'));
        //TODO Throttle: https://github.com/danharrin/livewire-rate-limiting })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
    }
}
