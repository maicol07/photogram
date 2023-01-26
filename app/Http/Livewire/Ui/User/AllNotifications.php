<?php

namespace App\Http\Livewire\Ui\User;

use App\Http\Livewire\InsidePage;
use Illuminate\Contracts\View\View;
use Illuminate\Notifications\DatabaseNotification;

class AllNotifications extends InsidePage
{
    public function markAsRead(DatabaseNotification $notification): void
    {
        $notification->markAsRead();
    }

    public function page(): View
    {
        return view('livewire.ui.user.all-notifications');
    }
}
