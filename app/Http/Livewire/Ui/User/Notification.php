<?php

namespace App\Http\Livewire\Ui\User;

use App\Http\Livewire\Traits\MDCMenuFeatures;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notification extends Component
{
    use MDCMenuFeatures;

    public DatabaseNotificationCollection|Collection $notifications;

    public function mount(): void
    {
        $this->notifications = Auth::user()->unreadNotifications;
    }

    public function openNotification(): void
    {
        $this->openMenu('menu-notifications');
    }

    public function markAsRead(DatabaseNotification $notification): void
    {
        $notification->markAsRead();
        $this->notifications = Auth::user()->unreadNotifications;
    }

    public function showAll(): void
    {
        $this->redirectRoute('inside.allNotifications');
    }

    public function render(): View
    {
        return view('livewire.ui.user.notification');
    }
}
