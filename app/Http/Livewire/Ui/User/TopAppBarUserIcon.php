<?php

namespace App\Http\Livewire\Ui\User;

use App\Http\Livewire\Traits\MDCMenuSurfaceFeatures;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TopAppBarUserIcon extends Component
{
    use MDCMenuSurfaceFeatures;

    public function openLogoutMenu(): void
    {
        $this->openMenuSurface('user-logout-menu');
    }

    public function render(): View
    {
        return view('livewire.ui.user.top-app-bar-user-icon');
    }
}
