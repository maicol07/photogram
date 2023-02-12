<?php

namespace App\Http\Livewire\Posts;

use App\Http\Livewire\Traits\MDCDialogFeatures;
use App\Http\Livewire\Traits\MDCMenuSurfaceFeatures;
use App\Models\Comment;
use App\Models\Post;
use App\Notifications\CommentNotification;
use App\Notifications\LikeNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PostView extends Component
{
    use MDCMenuSurfaceFeatures;
    use MDCDialogFeatures;

    public Post $post;
    public string $commentContent = '';
    public bool $editMode = false;
    public Comment $editC;
    /** @var Collection<Comment> */
    public int $width = 100;

    protected $listeners = [
        'refreshPostView' => '$refresh',
        'editComment' => 'editComment',
    ];

    public function mount(Post|int $post): void
    {
        $this->post = ($post instanceof Post) ?  $post : Post::find($post);
    }

    public function share(): void
    {
        $this->openMenuSurface('share-menu-' . $this->post->id);
    }

    public function addComment(): void
    {
        if ($this->editMode) {
            $this->editC->content = $this->commentContent;
            $this->editC->save();
        } elseif ($this->commentContent !== '') {
            $comment = new Comment();
            $comment->content = $this->commentContent;
            $comment->post()->associate($this->post);
            $comment->user()->associate(Auth::user());
            $comment->save();
            if ($comment->post->user->id !== $comment->user->id) {
                $comment->post->user->notify(new CommentNotification($comment->user));
            }
        }
        $this->editMode = false;
        $this->emitSelf('refreshPostView');
        $this->commentContent = '';
    }

    public function editComment(Comment $c): void
    {
        $this->editMode = true;
        $this->commentContent = $c->content;
        $this->editC = $c;
    }

    public function likeToggle(): void
    {
        $this->post->likes()->toggle(Auth::user()->id);
        if ($this->post->likes()->where('user_id', '=', Auth::user()->id)->exists() && $this->post->user->id !== Auth::user()->id) {
            $this->post->user->notify(new LikeNotification(Auth::user()));
        }
    }

    public function render(): View
    {
        return view('livewire.posts.post-view');
    }
}
