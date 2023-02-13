<?php

namespace App\Http\Livewire\User;

use App\Http\Livewire\InsidePage;
use App\Http\Livewire\Traits\MDCDialogFeatures;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewFollowerNotification;
use Auth;
use Illuminate\Contracts\View\View;

class Profile extends InsidePage
{
    use MDCDialogFeatures;

    public User $user;

    protected $listeners = ['editProfile' => 'editProfile', 'followersChanged' => '$refresh'];

    public function mount(User $user): void
    {
        $this->user = $user->exists ? $user : Auth::user();
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

    public function getTitle(): string
    {
        return $this->user->name . ' ' . $this->user->surname;
    }

    public function viewPost(Post $post): void
    {
        $this->redirectRoute('inside.viewPost', ['post' => $post]);
    }

    public function page(): View
    {
        return view('livewire.user.profile');
    }
}
