<?php

namespace App\Http\Livewire\Ui\Language;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Component;
use Locale;

class Select extends Component
{
    public string $locale;

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
        return collect(File::glob(base_path('lang/*.json')))
            ->map(static fn (string $file) => File::name($file))
            ->mapWithKeys(static fn (string $lang) => [$lang => Str::ucfirst(Locale::getDisplayLanguage($lang, app()->getLocale()))])
            ->toArray();
    }

    public function render(): View
    {
        return view('livewire.ui.language.select');
    }
}
