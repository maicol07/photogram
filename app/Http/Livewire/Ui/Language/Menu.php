<?php

namespace App\Http\Livewire\Ui\Language;

use App\Http\Livewire\Traits\MDCMenuFeatures;
use Illuminate\Contracts\View\View;

class Menu extends LanguageComponent
{
    use MDCMenuFeatures;
    public function openLanguagesMenu(): void
    {
        $this->openMenu('languages-menu');
    }

    public function render(): View
    {
        return view('livewire.ui.language.menu');
    }
}
