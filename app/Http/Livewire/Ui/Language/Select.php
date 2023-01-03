<?php

namespace App\Http\Livewire\Ui\Language;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Select extends Component
{
    public string $locale = 'en';

    public function mount(): void
    {
        $this->locale = app()->getLocale();
    }

    public function updatingLocale(string $locale): void
    {
        session()->put('locale', $locale);
        app()->setLocale($locale);
        $this->emit('localeChanged', $locale);
    }

    public function getLanguages(): array
    {
        return ['en' => __('English'), 'it' => __('Italian')];
    }

    public function render(): View
    {
        return view('livewire.ui.language.select');
    }
}
