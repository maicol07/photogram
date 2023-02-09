<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class Home extends InsidePage
{
    public function page(): View
    {
        return view('livewire.home');
    }

    public function getTitle(): string
    {
        return __('Home');
    }

    /**
     * @return Collection<Post>
     */
    public function getPosts(): Collection
    {
        $followed_ids = auth()->user()?->follows()->pluck('users.id');
        return Post::whereIn('user_id', $followed_ids)->get();
    }
}
