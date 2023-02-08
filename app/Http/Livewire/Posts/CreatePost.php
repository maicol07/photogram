<?php

namespace App\Http\Livewire\Posts;

use App\Http\Livewire\InsidePage;
use App\Models\Post;
use App\Notifications\NewPostNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class CreatePost extends InsidePage
{
    use WithFileUploads;

    public Post $post;
    public $image;
    public int $maxLength = 1024;

    protected $rules = [
        'image' => 'required',
        'post.description' => 'nullable|string|max:140',
        'post.photo' => 'nullable|string|max:1024'
    ];

    public function mount(null|Post $post): void
    {
        $this->post = ($post instanceof Post) ? $post : new Post();
        if ($post instanceof Post) {
            $this->image = $post->photo;
        }
    }

    public function upload(): void
    {
        $this->validate();
        if ($this->image instanceof TemporaryUploadedFile) {
            $path = $this->image->store('public/post/images');
            $this->post->photo = basename($path);
        }
        $this->post->user_id = Auth::user()->id;
        $this->post->save();

        foreach ($this->post->user->followers as $follower) {
            $follower->notify(new NewPostNotification($this->post->user));
        }

        $this->redirectRoute('inside.viewPost', $this->post);
    }

    public function goToProfile(): void
    {
        $this->redirectRoute('inside.profile');
    }

    public function delete(): void
    {
        if ($this->post->exists){
            $this->post->delete();
        }
        $this->goToProfile();
    }

    public function page(): View
    {
        return view('livewire.posts.create-post');
    }
}