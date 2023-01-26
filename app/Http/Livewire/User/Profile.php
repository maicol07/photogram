<?php

namespace App\Http\Livewire\User;

use App\Http\Livewire\InsidePage;
use App\Http\Livewire\Traits\MDCDialogFeatures;
use App\Models\User;
use App\Notifications\NewFollowerNotification;
use Auth;
use Illuminate\Contracts\View\View;

class Profile extends InsidePage
{
    use MDCDialogFeatures;

    public User $user;

    public array $posts = [
        ['img' => 'https://picsum.photos/200/200', 'alt' => 'alt1', 'text' => 'text1'],
        ['img' => 'https://picsum.photos/200/200', 'alt' => 'alt2', 'text' => 'text2'],
        ['img' => 'https://picsum.photos/200/200', 'alt' => 'alt3', 'text' => 'text3'],
    ];

    protected $listeners = ['editProfile' => 'editProfile', 'followersChanged' => '$refresh'];

    public function mount(?string $username = null): void
    {
        $this->user = $username ? User::where('username', $username)->first() : Auth::user();
    }

    public function editProfile(): void
    {
        $this->closeDialog('profile-dialog', __('Close dialog'));
    }

    public function follow(): void
    {
        $this->user->followers()->attach(Auth::user()->id);
        $this->user->notify((new NewFollowerNotification(Auth::user())));
        $this->user->save();
        $this->emitSelf('followerChanged');

    }

    public function unfollow(): void
    {
        $this->user->followers()->detach(Auth::user()->id);
        $this->user->save();
        $this->emitSelf('followerChanged');
    }

    public function page(): View
    {
        return view('livewire.user.profile');
    }
}
