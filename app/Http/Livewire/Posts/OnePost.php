<?php

namespace App\Http\Livewire\Posts;

use App\Http\Livewire\InsidePage;
use App\Models\Post;
use Illuminate\Contracts\View\View;

class OnePost extends InsidePage
{
    public Post $post;

    public function page(): View
    {
        return view('livewire.posts.one-post');
    }

    public function getTitle(): string
    {
        return __('View Post');
    }
}
