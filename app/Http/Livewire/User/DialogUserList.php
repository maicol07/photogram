<?php

namespace App\Http\Livewire\User;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class DialogUserList extends Component
{
    public Collection $userList;

    public function render(): View
    {
        return view('livewire.user.dialog-user-list');
    }
}
