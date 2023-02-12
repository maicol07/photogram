<?php

namespace App\Http\Livewire\Posts;

use App\Http\Livewire\Traits\MDCDialogFeatures;
use App\Http\Livewire\Traits\MDCMenuFeatures;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CommentComponent extends Component
{
    use MDCDialogFeatures;
    use MDCMenuFeatures;

    public Comment $c;
    public Post $post;
    public ?string $tabindex = null;

    public function commentLikeToggle(int $commentId): void
    {
        $this->post->comments()->find($commentId)->likes()->toggle(Auth::user()->id);
    }

    public function goToProfile(): void
    {
        $this->redirectRoute('inside.profile', $this->c->user->username);
    }

    public function deleteComment(int $commentId): void
    {
        $this->c->delete();
        $this->emit('refreshPostView');
    }

    public function editComment(): void
    {
        $this->emitUp('editComment', $this->c);
        $this->dispatchBrowserEvent("edit-comment-{$this->post->id}");
    }

    public function render(): View
    {
        return view('livewire.posts.comment-component');
    }
}
