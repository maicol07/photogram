<?php

namespace App\Http\Livewire\User;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Dialog extends Component
{
    use WithFileUploads;

    public bool $open = false;

    public $image = '';

    public string $bio = '';

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

        $this->image->store('image');
        $this->emitUp('editProfile', ['img' => $this->image, 'bio' => $this->bio]);
    }

    public function render(): View
    {
        return view('livewire.user.dialog');
    }
}
