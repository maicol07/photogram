<?php

namespace App\Http\Livewire\Ui\Language;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Component;
use Locale;

abstract class LanguageComponent extends Component
{
    public string $locale;

    public function mount(): void
    {
        $this->locale = app()->getLocale();
    }

    public function updatedLocale(string $locale): void
    {
        session()->put('locale', $locale);
        app()->setLocale($locale);
        $this->emit('localeChanged', $locale);
    }

    public function getLanguages(): array
    {
        return collect(File::glob(base_path('lang/*.json')))
            ->map(static fn (string $file) => File::name($file))
            ->mapWithKeys(fn (string $lang) => [
                $lang => [
                    'label' => $this->getLocaleDisplayName($lang),
                    'graphic' => "<img src='{$this->getFlag($lang)}' alt='{$this->getLocaleDisplayName($lang)}' class='mdc-deprecated-list-item__graphic'/>",
                ],
            ])
            ->toArray();
    }

    private function getFlag(string $locale): string
    {
        return asset("vendor/blade-flags/language-$locale.svg");
    }

    private function getLocaleDisplayName(string $locale): string
    {
        return Str::ucfirst(Locale::getDisplayLanguage($locale, app()->getLocale()));
    }
}
