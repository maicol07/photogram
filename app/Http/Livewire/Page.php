<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

abstract class Page extends Component
{
    protected $listeners = ['localeChanged' => 'reloadPage'];

    public function boot(): void
    {
        app()->setLocale(session()->get('locale', 'en'));
    }

    public function reloadPage(): void
    {
        $this->redirect(request()?->header('referer'));
    }

    public function getTitle(): string
    {
        return '';
    }

    public function render(): View
    {
        return $this->page();
    }

    abstract public function page(): View;
}
