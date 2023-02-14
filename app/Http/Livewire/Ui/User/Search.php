<?php

namespace App\Http\Livewire\Ui\User;

use App\Http\Livewire\InsidePage;
use App\Http\Livewire\Traits\MDCDialogFeatures;
use App\Http\Livewire\Traits\MDCSnackbarFeatures;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class Search extends InsidePage
{
    use MDCDialogFeatures;
    use MDCSnackbarFeatures;

    public string $username = '';

    public Collection $users;

    public function mount(): void
    {
        $this->users = User::all()->pluck('username');
    }

    public function updatedUsername(): void
    {
        $this->users = User::where('username', 'LIKE', '%'. $this->username . '%')->pluck('username');
    }

    public function search(): void
    {
        $user = User::where('username', '=', $this->username)->exists();
        if ($user) {
            $this->redirectRoute('inside.profile', $this->username);
        } else {
            $this->openSnackbar('searchMessage', __('User not found. Select a user from the textfield list.'));
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
