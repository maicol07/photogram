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

    /**
     * Opens a snackbar with the given action ID
     */
    public function openSnackbar(string $id, ?string $message = null, ?string $openAction = null): void
    {
        $this->openCloseComponent($id, 'MDCSnackbar', true, $openAction, $message);
    }

    /**
     * Closes a snackbar with the given action ID
     */
    public function closeSnackbar(string $id, ?string $closeAction = null): void
    {
        $this->openCloseComponent($id, 'MDCSnackbar', false, $closeAction);
    }

    /**
     * Opens a dialog with the given action ID
     */
    public function openDialog(string $id, ?string $openAction = null): void
    {
        $this->openCloseComponent($id, 'MDCDialog', true, $openAction);
    }

    /**
     * Closes a dialog with the given action ID
     */
    public function closeDialog(string $id, ?string $closeAction = null): void
    {
        $this->openCloseComponent($id, 'MDCDialog', false, $closeAction);
    }

    /**
     * Dispatches a browser event to open or close a component
     *
     * @param string $id ID of the component
     * @param string $component Name of the component (i.e., MDCDialog or MDCSnackbar)
     * @param bool $open Whether to open or close the component
     * @param string|null $action Action id of the action to be performed
     * @param string|null $message Message to be displayed (only for snackbar)
     */
    private function openCloseComponent(string $id, string $component, bool $open, ?string $action = null, ?string $message = null): void
    {
        $actionType = $open ? 'open' : 'close';
        $this->dispatchBrowserEvent("$component::$actionType", compact('id', 'action', 'message'));
    }
}
