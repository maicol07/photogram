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
        'user.bio' => 'nullable|string|max:140',
        'image' => 'nullable|file|image'
    ];

    /**
     * The profile image of user
     *
     * @var TemporaryUploadedFile
     */
    public $image;

    public int $maxLength = 140;

    public function close(): void
    {
        $this->emitUp('editProfile');
    }

    public function accept(): void
    {
        $this->validate();

        if ($this->image !== null) {
            assert($this->image instanceof TemporaryUploadedFile);
            $path = $this->image->store('public/profile/images');
            $this->user->profileImage = basename($path);
        }
        $this->user->save();
        $this->emitUp('editProfile');
    }

    public function removeImage(): void
    {
        $this->user->profileImage = null;
        $this->user->save();
        $this->emitUp('editProfile');
    }

    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function render(): View
    {
        return view('livewire.user.dialog');
    }
}
