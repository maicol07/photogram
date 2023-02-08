<?php

namespace App\Http\Livewire\Ui\Post;

use Livewire\Component;

class NewPostButton extends Component
{

    public function goToNewPost(): void
    {
        $this->redirectRoute('inside.newPost');
    }

    public function render()
    {
        return view('livewire.ui.post.new-post-button');
    }
}
