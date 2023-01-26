<?php

namespace App\Http\Livewire\Ui\Language;

use Illuminate\Contracts\View\View;

class Select extends LanguageComponent
{
    public function render(): View
    {
        return view('livewire.ui.language.select');
    }
}
