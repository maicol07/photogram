<?php

namespace App\Http\Livewire\User;

use App\Http\Livewire\Page;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Profile extends Page
{
    public User $user;

    public int $numberPosts = 0;

    public int $numberFollowers = 0;

    public int $numberFollows = 0;

    public array $posts = [
        ['img' => 'https://picsum.photos/200/200', 'alt' => 'alt1', 'text' => 'text1'],
        ['img' => 'https://picsum.photos/200/200', 'alt' => 'alt2', 'text' => 'text2'],
        ['img' => 'https://picsum.photos/200/200', 'alt' => 'alt3', 'text' => 'text3']
    ];

    public bool $open = false;

    protected $listeners = ['editProfile' => 'editProfile'];

    public function mount(): void
    {
        $this->user = User::find(1);
        $this->numberPosts = $this->user->posts()->count();
        $this->numberFollowers = $this->user->followers()->count();
        $this->numberFollows = $this->user->follows()->count();
    }

    public function editProfile(): void
    {
        $this->open = false;
    }

    public function openDialog(): void
    {
        $this->open = true;
    }

    public function page(): View
    {
        return view('livewire.user.profile');
    }
}
