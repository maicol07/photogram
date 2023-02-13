<?php

namespace App\Http\Livewire\Ui\User;

use App\Http\Livewire\InsidePage;
use App\Http\Livewire\Traits\MDCDialogFeatures;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class Search extends InsidePage
{
    use MDCDialogFeatures;

    public string $username = '';

    public Collection $users;

    public function mount(): void
    {
        $this->users = collect();
    }

    public function updatedUsername(): void
    {
        $this->users = User::where('username', 'LIKE', '%'. $this->username . '%')->pluck('username');
    }

    public function search(): void
    {
        if (User::where('username', '=', $this->username)->exists()) {
            $this->redirectRoute('inside.profile', ['username' => $this->username]);
        }
    }

    public function openSearch(): void
    {
        $this->openDialog('dialog-search');
    }

    public function page(): View
    {
        return view('livewire.ui.user.search');
    }
}
