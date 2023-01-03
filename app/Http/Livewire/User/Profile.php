<?php

namespace App\Http\Livewire\User;

use App\Http\Livewire\Page;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Profile extends Page
{
    public $imageProfile = 'https://picsum.photos/200/200';

    public int $numberPosts = 0;

    public int $numberFollowers = 0;

    public int $numberFollows = 0;

    public string $bio = 'Biografia';

    public array $posts = [
        ['img' => 'https://picsum.photos/200/200', 'alt' => 'alt1', 'text' => 'text1'],
        ['img' => 'https://picsum.photos/200/200', 'alt' => 'alt2', 'text' => 'text2'],
        ['img' => 'https://picsum.photos/200/200', 'alt' => 'alt3', 'text' => 'text3']
    ];

    public bool $open = false;

    protected $listeners = ['editProfile' => 'editProfile'];

    public function editProfile(array $values): void
    {
        foreach ($values as $prop => $value) {
            $this->$prop = $value;
        }
        $this->emitSelf('closeDialog');
    }

    public function openDialog(): void
    {
        $this->open = true;
        $this->emitSelf('openDialog');
    }

    public function page(): View
    {
        return view('livewire.user.profile', ['user' => auth()->user()]);
    }
}
