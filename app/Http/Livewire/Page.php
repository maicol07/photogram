<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

abstract class Page extends Component
{
    protected $listeners = ['localeChanged' => '$refresh'];

    public function hydrate(): void
    {
        app()->setLocale(session()->get('locale', 'en'));
    }

    public function render(): View
    {
        return $this->page()
            ->extends('layouts.base')
            ->section('content');
    }

    abstract public function page(): View;
}
