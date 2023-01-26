<?php

namespace App\Http\Livewire\Traits;

trait MDCFeatures
{

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
