<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class Dialog extends Component
{
    use WithFileUploads;

    public User $user;

    protected $rules = [
        'user.bio' => 'string|max:140',
        'user.profileImage' => 'string',
    ];

    /**
     * The profile image of user
     *
     * @var TemporaryUploadedFile
     */
    public $image;

    public bool $open = false;

    public function close(): void
    {
        $this->emitUp('editProfile', []);
    }

    public function accept(): void
    {
        //TODO:caricare l'immagine correttamente
        $this->validate([
            'image' => 'image|max:1024', // 1MB Max
        ]);

        assert($this->image instanceof TemporaryUploadedFile);
        $path = $this->image->store('public');
        $this->user->profileImage = basename($path);
        $this->user->save();
        $this->emitUp('editProfile');
    }

    public function render(): View
    {
        return view('livewire.user.dialog');
    }
}
